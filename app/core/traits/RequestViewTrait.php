<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits;

use app\core\helpers\View\Form\BaseFormHelper;
use app\core\helpers\View\Form\FormHelper;
use app\core\helpers\View\Form\StandHelper;
use app\core\services\operations\Requests\RequestService;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\EditRequestForm;
use Yii;

/**
 *
 * @author kotov
 */
trait RequestViewTrait
{    
    /**
     *
     * @var RequestService
     */
    protected $service;
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {        
        /** @var Request $model */
        $userId = Yii::$app->user->id;
        $langCode = Yii::$app->language;
        $model =  $this->findModel($id);
        $this->viewPath = Yii::getAlias('@views') .  DIRECTORY_SEPARATOR .'requests';    
        $rejectLogs = $this->applicationRejectLogService->getLogsForRequest($id);
        $requestForm = $model->requestForm;
        $statusForm = new EditRequestForm($model);  
        if ($requestForm->form->form_type_id == FormType::SPECIAL_STAND_FORM) {            
            $formHelper = StandHelper::createViaRequest($userId, $langCode, $model);
        } else {
            $formHelper = FormHelper::createViaRequest($userId, $langCode, $model);            
        }
        $formHtmlData = $formHelper->renderHtmlRequest();
        if ($statusForm->load(Yii::$app->request->post()) && $statusForm->validate()) {
            $model = $this->service->changeStatus($statusForm);
            Yii::$app->session->setFlash('success','Статус заявки успешно изменен');            
        }
        return $this->render('view', [
            'model' => $model,
            'statusForm' => $statusForm,
            'requestHtml' => $formHtmlData,
            'logs' => $rejectLogs            
        ]);
    }
    
    public function actionPrint($id)
    {        
        $model =  $this->findModel($id);
        $helper = $this->getFormHelper($model);
        return $helper->renderPDF();
    }  
    
    protected function getFormHelper(Request $model) :BaseFormHelper
    {
        $userId = Yii::$app->user->id;
        $langCode = Yii::$app->language;
        
        $requestForm = $model->requestForm;
        if ($requestForm->form->form_type_id == FormType::SPECIAL_STAND_FORM) {            
            $formHelper = StandHelper::createViaRequest($userId, $langCode, $model);
        } else {
            $formHelper = FormHelper::createViaRequest($userId, $langCode, $model);            
        }
        return $formHelper;
    }
}
