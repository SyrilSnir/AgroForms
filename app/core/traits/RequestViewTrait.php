<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits;

use app\core\helpers\View\Form\FormHelper;
use app\core\helpers\View\Form\StandHelper;
use app\core\services\operations\Requests\RequestService;
use app\core\services\operations\View\Requests\RequestViewFactory;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ChangeStatusForm;
use kartik\mpdf\Pdf;
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
        $this->viewPath = Yii::getAlias('@views') .  DIRECTORY_SEPARATOR .'requests';    
        $rejectLogs = $this->applicationRejectLogService->getLogsForRequest($id);        
        $model = $this->findModel($id);
        $requestForm = $model->requestForm;
        $viewService = RequestViewFactory::getViewService($model);
        $dopAttributes = $viewService->getFieldAttributes($requestForm);
        $statusForm = new ChangeStatusForm($model->id, $model->status);  
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
            'dopAttributes' => $dopAttributes,
            'statusForm' => $statusForm,
            'requestHtml' => $formHtmlData,
            'logs' => $rejectLogs            
        ]);
    }
    
    public function actionPrint($id)
    {
        /** @var Request $model */
        $model =  $this->findModel($id);
        $exhibitionName = mb_strtoupper($model->form->exhibition->title);
        $requestForm = $model->requestForm;
        $viewService = RequestViewFactory::getViewService($model);
        $dopAttributes = $viewService->getFieldAttributes($requestForm);
      // dump($dopAttributes); die();
        
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_pdf',[
            'model' => $model,
            'fields' => $dopAttributes
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px};.headtext{color:red}', 
             // set mPDF properties on the fly
            'options' => ['title' => ''],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>[$exhibitionName], 
                'SetFooter'=>['{PAGENO}'],
                'SetTitle' =>  t('Application №','requests') . $model->id,
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();         
    }    
}
