<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\controllers;

use app\core\manage\Auth\Rbac;
use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\Log\ApplicationRejectLogService;
use app\core\services\operations\Requests\RequestService;
use app\core\traits\GridViewTrait;
use app\core\traits\RequestViewTrait;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ApplicationRejectForm;
use app\models\Forms\Requests\EditRequestForm;
use app\models\SearchModels\Requests\AccountantRequestSearch;
use app\models\SearchModels\Requests\ManagerRequestSearch;
use DomainException;
use kartik\mpdf\Pdf;
use Yii;
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
    
    protected $roles = [
        Rbac::PERMISSION_ADMINISTRATOR_MENU,
        Rbac::PERMISSION_MANAGER_MENU,
        Rbac::PERMISSION_ACCOUNTANT_MENU,
        Rbac::PERMISSION_ORGANIZER_MENU];

    use GridViewTrait,RequestViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            ManagerRequestSearch $managerSearchModel,
            AccountantRequestSearch $accountantSearchModel,
            RequestReadRepository $repository, 
            RequestService $requestService,
            ApplicationRejectLogService $applicationRejectLogService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
     //   $this->readRepository = $repository;
    //    $this->service = $service;
        if (Yii::$app->user->can(Rbac::PERMISSION_ACCOUNTANT_MENU)) {
            $this->searchModel = $accountantSearchModel;
        } else {
            $this->searchModel = $managerSearchModel;
        }
        $this->readRepository = $repository;
        $this->service = $requestService;
        $this->applicationRejectLogService = $applicationRejectLogService;
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
        try {
            $this->service->invoice($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }        
        return $this->redirect(Url::previous());        
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
}
