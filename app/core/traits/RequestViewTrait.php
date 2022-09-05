<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits;

use app\core\helpers\View\Form\BaseFormHelper;
use app\core\helpers\View\Form\ExcelHeaderView;
use app\core\helpers\View\Form\FormHelper;
use app\core\helpers\View\Form\StandHelper;
use app\core\helpers\View\Request\RequestStatusHelper;
use app\core\manage\Auth\UserIdentity;
use app\core\services\operations\Requests\RequestService;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\EditRequestForm;
use app\models\Forms\Requests\ExcelLoadForm;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
        /** @var UserIdentity $userIdentity */
        $userIdentity = Yii::$app->user->getIdentity();

        $langCode = Yii::$app->language;
        $model =  $this->findModel($id);
        $this->viewPath = Yii::getAlias('@views') .  DIRECTORY_SEPARATOR .'requests';    
        $rejectLogs = $this->applicationRejectLogService->getLogsForRequest($id);
        $requestForm = $model->requestForm;
        $statusForm = new EditRequestForm($model);  
        if ($requestForm->form->form_type_id == FormType::SPECIAL_STAND_FORM) {            
            $formHelper = StandHelper::createViaRequest($userIdentity->getUser(), $langCode, $model);
        } else {
            $formHelper = FormHelper::createViaRequest($userIdentity->getUser(), $langCode, $model);            
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
    
    public function actionExcel() 
    {
        $form = new ExcelLoadForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->printExcelDocument($form->formId);
            return;
        } else {
            $this->viewPath = Yii::getAlias('@views') .  DIRECTORY_SEPARATOR .'requests';
            return $this->render('excel-form',[
                'model' => $form
            ]);
        }
    }
    
    protected function getFormHelper(Request $model) :BaseFormHelper
    {
        /** @var UserIdentity $userIdentity */
        $userIdentity = Yii::$app->user->getIdentity();
        $langCode = Yii::$app->language;
        
        $requestForm = $model->requestForm;
        if ($requestForm->form->form_type_id == FormType::SPECIAL_STAND_FORM) {            
            $formHelper = StandHelper::createViaRequest($userIdentity->getUser(), $langCode, $model);
        } else {
            $formHelper = FormHelper::createViaRequest($userIdentity->getUser(), $langCode, $model);            
        }
        return $formHelper;
    }
    
    protected function printExcelDocument(int $formId)
    {
        $form = Form::findOne($formId);
        $langCode = Yii::$app->language;
        $userIdentity = Yii::$app->user->getIdentity(); 
        $formHelper = FormHelper::createViaForm($userIdentity->getUser(), $langCode, $form);
        $requests = Request::find()
                ->andWhere(['form_id' => $formId])
                ->andWhere(['NOT IN', 'status', 
                    [
                        BaseRequest::STATUS_DRAFT,
                        BaseRequest::STATUS_REJECTED,
                        BaseRequest::STATUS_DELETE
                    ]
                        ])
                ->all();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=ANSI');                                
        header('Content-Disposition: attachment;filename="requests'.date('d.m.Y').'.xlsx"');
        header('Cache-Control: max-age=0'); 
        $xls = new Spreadsheet();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Данные по заявкам');
        $this->prepareExcelHeader($sheet, $formHelper);
        $vIndex = 3;
        foreach ($requests as $request) {
            /** @var Request $request */
            $sheet->setCellValue([1,$vIndex], $request->company->name);
            $sheet->setCellValue([2,$vIndex], RequestStatusHelper::getStatusName($request->status));
            $vIndex++;
        }
        $objWriter = new Xlsx($xls);
        
        $objWriter->save('php://output'); 
        die();
    }
    
    protected function prepareExcelHeader(Worksheet $sheet,BaseFormHelper $formHelper)
    {
        $sheet->setCellValue([1,1],$formHelper->getPrintedElementsCount());
        $sheet->setCellValue([1,2], t('Company', 'company'));
        $sheet->setCellValue([2,2], t('Application status'));
        $headerElements = $formHelper->getExcelHeader(3);
        foreach ($headerElements as $headerElement) {
            /** @var ExcelHeaderView $element */
            $element = $headerElement['element'];
            $startedIndex = $headerElement['startedIndex'];
            $sheet->setCellValue([$startedIndex,2], $element->getTitle());
        }
    }
}
