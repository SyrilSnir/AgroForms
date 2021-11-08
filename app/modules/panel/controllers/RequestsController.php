<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\controllers;

use app\core\manage\Auth\Rbac;
use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\operations\Requests\RequestService;
use app\core\traits\GridViewTrait;
use app\core\traits\RequestViewTrait;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ChangeStatusForm;
use app\models\SearchModels\Requests\AccountantRequestSearch;
use app\models\SearchModels\Requests\ManagerRequestSearch;
use DomainException;
use Yii;
use yii\helpers\Url;

/**
 * Description of RequestController
 *
 * @author kotov
 */
class RequestsController extends ManageController
{
    
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
    }  
    
    public function actionChangeStatus($id) 
    {
        /** @var Request $model */
        $model =  $this->findModel($id);
        $changeStatusForm = new ChangeStatusForm($model->id, $model->status); 
        if ($changeStatusForm->load(Yii::$app->request->post()) && $changeStatusForm->validate()) {
            $this->service->changeStatus($changeStatusForm);
            return $this->redirect(['view', 'id' => $id]);            
        }
        return $this->render('change-status', [
            'model' => $changeStatusForm,
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
        try {
            $this->service->reject($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }        
        return $this->redirect(Url::previous());        
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
}
