<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\controllers;

use app\core\manage\Auth\Rbac;
use app\core\manage\Auth\UserIdentity;
use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\Log\ApplicationRejectLogService;
use app\core\services\operations\Documents\DocumentService;
use app\core\services\operations\Requests\RequestService;
use app\core\traits\GridViewTrait;
use app\core\traits\RequestViewTrait;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Manage\Document\DocumentForm;
use app\models\Forms\Requests\ApplicationRejectForm;
use app\models\Forms\Requests\EditRequestForm;
use app\models\SearchModels\Requests\AcceptedRequestSearch;
use app\models\SearchModels\Requests\AccountantRequestSearch;
use app\models\SearchModels\Requests\ManagerRequestSearch;
use app\models\SearchModels\Requests\MediaManagerRequestSearch;
use app\models\SearchModels\Requests\NewRequestSearch;
use app\models\SearchModels\Requests\RejectedRequestSearch;
use DomainException;
use Yii;
use yii\base\Action;
use yii\helpers\Url;

/**
 * Description of RequestController
 *
 * @author kotov
 */
class RequestsController extends ManageController
{
    /**
     * 
     * @var ApplicationRejectLogService
     */
    protected  $applicationRejectLogService;
    
    /**
     * 
     * @var DocumentService
     */
    protected $documentService;


    protected $roles = [
        Rbac::PERMISSION_ADMINISTRATOR_MENU,
        Rbac::PERMISSION_MANAGER_MENU,
        Rbac::PERMISSION_ACCOUNTANT_MENU,
        Rbac::PERMISSION_MEDIA_MANAGER_MENU,
        Rbac::PERMISSION_ORGANIZER_MENU];

    use GridViewTrait,RequestViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            ManagerRequestSearch $managerSearchModel,
            MediaManagerRequestSearch $mediaManagerSearchModel,
            AccountantRequestSearch $accountantSearchModel,
            RequestReadRepository $repository, 
            RequestService $requestService,
            DocumentService $documentService,
            ApplicationRejectLogService $applicationRejectLogService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
     //   $this->readRepository = $repository;
    //    $this->service = $service;
        if (Yii::$app->user->can(Rbac::PERMISSION_ACCOUNTANT_MENU)) {
            $this->searchModel = $accountantSearchModel;
        } elseif (Yii::$app->user->can(Rbac::PERMISSION_MEDIA_MANAGER_MENU)) {
            $this->searchModel = $mediaManagerSearchModel;
        }
        else {
            $this->searchModel = $managerSearchModel;
        }
        $this->readRepository = $repository;
        $this->service = $requestService;
        $this->applicationRejectLogService = $applicationRejectLogService;
        $this->documentService = $documentService;
    }  
    /**
     * 
     * @param Action $action
     * @return bool
     */
    public function beforeAction($action): bool
    {
        if ($action->id == 'new') {
            $this->searchModel = new NewRequestSearch();
        }
        if ($action->id == 'rejected') {
            $this->searchModel = new RejectedRequestSearch();
        }      
        if ($action->id == 'accepted') {
            $this->searchModel = new AcceptedRequestSearch();
        }         
        return parent::beforeAction($action);
    }

    public function actionNew()
    {
        return $this->actionIndex();
    }

    public function actionAccepted()
    {
        return $this->actionIndex();        
    }
 
    public function actionRejected()
    {
        return $this->actionIndex();        
    }

    public function actionEdit($id) 
    {
        /** @var Request $model */
        $model =  $this->findModel($id);
        $editRequestForm = new EditRequestForm($model); 
        if ($editRequestForm->load(Yii::$app->request->post()) && $editRequestForm->validate()) {
            $this->service->edit($editRequestForm);
            return $this->redirect(['view', 'id' => $id]);            
        }
        return $this->render('edit', [
            'model' => $editRequestForm,
            'hasPublication' => $model->form->published
        ]);           
    }
           
    public function actionAccept($id)
    {
        try {
            $this->service->accept($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }        
        return $this->redirect(Url::previous());        
    }
    
    public function actionReject($id)
    {
        /** @var Request $model */
        $model =  $this->findModel($id);
        $applicationRejectForm = new ApplicationRejectForm($model->id);
        if($applicationRejectForm->load(Yii::$app->request->post()) && $applicationRejectForm->validate()) {
            try {
                $this->service->reject($applicationRejectForm);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }            
            return $this->redirect(Url::previous()); 
        }
        return $this->render('application-reject-log', [
            'model' => $applicationRejectForm,
        ]);         
    }

    public function actionInvoice($id)
    {
        /** @var Request $request */
        /** @var UserIdentity $user */
        $documentForm = new DocumentForm();
        $request = $this->readRepository->findById($id);
      //  $user = Yii::$app->user->getIdentity();
        if ($documentForm->load(Yii::$app->request->post()) && $documentForm->validate()) {
            try {
                $this->documentService->create($documentForm);
                $this->service->invoice($id);
                return $this->redirect(Url::previous());        
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }        
        }
        $invoiceData = [
            'title' => '',
            'titleEng' => '',
            'description' => 'Счет к договору №' . ($request->contract ? $request->contract->number : ''),
            'descriptionEng' => 'Invoice to contract No. ' . ($request->contract ? $request->contract->number : ''),
            'exhibitionId' => $request->exhibition_id,
            'companyId' => $request->company_id,
        ];        
        $documentForm->setAttributes($invoiceData);
        return $this->render('document-form', [
            'model' => $documentForm,
        ]);         
    }

    public function actionPay($id)
    {
        try {
            $this->service->pay($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }        
        return $this->redirect(Url::previous());        
    }    

    public function actionPartialPay($id)
    {
        try {
            $this->service->partialPay($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }        
        return $this->redirect(Url::previous());        
    }  
    
    public function actionPublish($id)
    {
        try {
            $this->service->publish($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }        
        return $this->redirect(Url::previous());        
    }    
    
    public function actionWithdraw($id)
    {
        try {
            $this->service->withdraw($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }        
        return $this->redirect(Url::previous());        
    }    
}
