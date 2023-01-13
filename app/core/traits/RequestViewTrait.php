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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
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
        $contract = $model->contract;
        $statusForm = new EditRequestForm($model);  
        if ($requestForm->form->form_type_id == FormType::SPECIAL_STAND_FORM) {            
            $formHelper = StandHelper::createViaRequest($userIdentity->getUser(),$contract, $langCode, $model);
        } else {
            $formHelper = FormHelper::createViaRequest($userIdentity->getUser(), $contract, $langCode, $model);            
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
        $contract = $model->contract;
        $requestForm = $model->requestForm;
        if ($requestForm->form->form_type_id == FormType::SPECIAL_STAND_FORM) {            
            $formHelper = StandHelper::createViaRequest($userIdentity->getUser(),$contract, $langCode, $model);
        } else {
            $formHelper = FormHelper::createViaRequest($userIdentity->getUser(), $contract, $langCode, $model);
        }
        return $formHelper;
    }
    
    protected function printExcelDocument(int $formId)
    {
        $form = Form::findOne($formId);
        $langCode = Yii::$app->language;
        $userIdentity = Yii::$app->user->getIdentity(); 
        $formHelper = FormHelper::createViaForm($userIdentity->getUser(), $langCode, $form);
        $formName = $form->name;
        
        $fileName = preg_replace('/[^\w\d\s\+\-\_]/u','',$formName);
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
        header('Content-Disposition: attachment;filename="'. $fileName .date('d.m.Y').'.xlsx"');
        header('Cache-Control: max-age=0'); 
        $xls = new Spreadsheet();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Данные по заявкам');
        $sheet->setCellValue([1,1],$form->getHeaderName());
        $cellsCount = $this->prepareExcelHeader($sheet, $formHelper);
        $rowsCount = count($requests);
        $this->prepareExcelBody($sheet, $requests);
        $this->postprocessExcel($sheet,$cellsCount,$rowsCount);
        
        $objWriter = new Xlsx($xls);
        
        $objWriter->save('php://output'); 
        die();
    }
    
    protected function prepareExcelHeader(Worksheet $sheet,BaseFormHelper $formHelper): int
    {
        $headerVIndex = 3;
        $headerGroupVIndex = $headerVIndex - 1;
        $sheet->setCellValue([1,$headerVIndex], t('Number of contract'));
        $sheet->setCellValue([2,$headerVIndex], t('Company', 'company'));
        $sheet->setCellValue([3,$headerVIndex], t('Member email','user'));
        $sheet->setCellValue([4,$headerVIndex], t('Application status'));
        $headerElements = $formHelper->getExcelHeader(5);
        $cellsCount = 0;
        foreach ($headerElements as $headerElement) {
            /** @var ExcelHeaderView $element */            
            $element = $headerElement['element'];
            $startedIndex = $headerElement['startedIndex'];
            $lenght = $element->getLength();
            if($element->hasChildren()) {
                $endIndex = $startedIndex + $lenght - 1;
                $sheet->mergeCells([$startedIndex,$headerGroupVIndex, $endIndex, $headerGroupVIndex]);                
                $sheet->setCellValue([$startedIndex,$headerGroupVIndex], $element->getTitle());
                $children = $element->getChildren();
                foreach ($children as $childElement) {
                    $sheet->setCellValue([$startedIndex++,$headerVIndex], $childElement->getTitle());
                }
            } else {
                $sheet->setCellValue([$startedIndex,$headerVIndex], $element->getTitle());
            }
            $cellsCount += $lenght;
        }
        return $cellsCount;
    }
    
    protected function prepareExcelBody(Worksheet $sheet, $requests) 
    {
        $defaultHIndex = 5;
        $defaultVIndex = 4;
        
        $vIndex = $defaultVIndex;
        $langCode = Yii::$app->language;
        $userIdentity = Yii::$app->user->getIdentity();        
        foreach ($requests as $request) {
            $hIndex = $defaultHIndex;
            /** @var Request $request */
            $sheet->setCellValue([1,$vIndex], $request->contract->number);
            $sheet->setCellValue([2,$vIndex], $request->company->name);
            $sheet->setCellValue([3,$vIndex], $request->user->email);
            $sheet->setCellValue([4,$vIndex], RequestStatusHelper::getStatusName($request->status));
            $formHelper = FormHelper::createViaRequest($userIdentity->getUser(), $langCode, $request);
            $fieldsList = $formHelper->getElementsForExcel();
            foreach ($fieldsList as $field) {
                if (is_array($field)) {
                    foreach($field as $groupField) {
                        $sheet->setCellValue([$hIndex,$vIndex], $groupField);
                        $hIndex++;
                    }
                } else {
                    $sheet->setCellValue([$hIndex,$vIndex], $field);
                    $hIndex++;
                }
            }
            $vIndex++;
        }        
    }
    
    protected function postprocessExcel(Worksheet $sheet, int $cellsCount,int $rowsCount) 
    {
        $borderStyle = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                
                            ],
                        ],
                    ];
        $headerBGColor = 'dbdbdb';
        $sheet->mergeCells([1,1,$cellsCount+4, 1]);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle([1,2,$cellsCount+4, $rowsCount+3])->applyFromArray($borderStyle);
        $sheet->getStyle([1,2,$cellsCount+4,3])->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($headerBGColor);
        $sheet->getStyle([1,2,$cellsCount+4,3])->getFont()->setBold(true);
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }        
    }
}
