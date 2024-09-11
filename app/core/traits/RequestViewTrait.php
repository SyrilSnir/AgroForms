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
use app\models\ActiveRecord\Contract\Contracts;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\EditRequestForm;
use app\models\Forms\Requests\ExcelLoadForm;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use ZipStream\Test\TimeTest;

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
        $contract = Contracts::createDummy();
        $formHelper = FormHelper::createViaForm($userIdentity->getUser(),$contract, $langCode, $form);
        $formName = $form->name;
        
        $fileName = preg_replace('/[^\w\d\s\+\-\_]/u','',$formName);
        $requests = Request::find()
                ->andWhere(['form_id' => $formId])
                ->andWhere(['NOT IN', 'status', 
                    [
                        BaseRequest::STATUS_DRAFT,
                        BaseRequest::STATUS_REJECTED,
                        BaseRequest::STATUS_DELETE,
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
        $headerElements = $formHelper->getExcelHeader(8);
        $headerHeight = $this->getExcelHeaderHeight($headerElements);        
        $cellsCount = $this->prepareExcelHeader($sheet, $headerElements, $headerHeight);
        $rowsCount = $this->prepareExcelBody($sheet, $requests, $headerHeight + 2);
        $this->postprocessExcel($sheet,$headerHeight + 1,$cellsCount,$rowsCount - 1);
        
        $objWriter = new Xlsx($xls);
        
        $objWriter->save('php://output'); 
        die();
    }
    
    protected function prepareExcelHeader(Worksheet $sheet,array $headerElements,int $headerHeight): int
    {
        $baseHeaderRowIndex = $headerHeight + 1;
        $sheet->setCellValue([1,$baseHeaderRowIndex], t('Number of contract'));
        $sheet->setCellValue([2,$baseHeaderRowIndex], t('Stand`s number'));
        $sheet->setCellValue([3,$baseHeaderRowIndex], t('Stand`s square, m2'));
        $sheet->setCellValue([4,$baseHeaderRowIndex], t('Рег. взнос, шт.'));
        $sheet->setCellValue([5,$baseHeaderRowIndex], t('Company', 'company'));
        $sheet->setCellValue([6,$baseHeaderRowIndex], t('Member email','user'));
        $sheet->setCellValue([7,$baseHeaderRowIndex], t('Application status'));
        $cellsCount = 0;
        foreach ($headerElements as $headerElement) {            
            /** @var ExcelHeaderView $element */            
            $element = $headerElement['element'];
            $startedIndex = $headerElement['startedIndex'];
            $lenght = $element->getLength();
            if($element->hasChildren()) {
                if ($element->isGroup()) {
                    $groupColumn = $headerHeight === 3 ? $baseHeaderRowIndex - 2 : $baseHeaderRowIndex - 1;
                }
                if ($element->isMultiColumns()) {
                    $groupColumn = $baseHeaderRowIndex - 1;

                }
                $endIndex = $startedIndex + $lenght - 1;
                $sheet->mergeCells([1,$groupColumn, 7, $groupColumn]); 
                $sheet->mergeCells([$startedIndex,$groupColumn, $endIndex, $groupColumn]); 
                $sheet->setCellValue([$startedIndex,$groupColumn], $element->getTitle());                
                $children = $element->getChildren();
                foreach ($children as $childElement) {
                    $sheet->setCellValue([$startedIndex++,$groupColumn + 1], $childElement->getTitle());
                }                
            } else {
                $sheet->setCellValue([$startedIndex,$element->getLength()], $element->getTitle());
            }
            $cellsCount += $lenght;
        }
        return $cellsCount;
    }
    
    protected function getExcelHeaderHeight(array $headerElements) : int 
    {
        $hasGroups = false;
        $hasMultiple = false;
        foreach ($headerElements as $headerElement) {
        /** @var ExcelHeaderView $el */          
            $el = $headerElement['element'];
            if ($el->isGroup()) {
                $hasGroups = true;
            }
            if ($el->isMultiColumns()) {
                $hasMultiple = true;
            }
        }
        if ($hasGroups && $hasMultiple) {
            return 3;
        }
        if ($hasGroups || $hasMultiple) {
            return 2;
        }
        return 1;
    }
    
    protected function prepareExcelBody(Worksheet $sheet, $requests, $defaultVIndex = 4):int 
    {
        $defaultHIndex = 8;
        $renderedList = [];
        $vIndex = $defaultVIndex;
        foreach ($requests as $request) {           
            $renderedList = $this->getRenderedFieldsForRow($request);  
            for ($iterator = 0; $iterator <= $renderedList['maxIterator']; $iterator++) {                
                $hIndex = $defaultHIndex;
                $this->renderRow($sheet, $request, $vIndex);
                foreach ($renderedList['elements'] as $field) {
                    if (is_array($field)) {
                        if (key_exists('group', $field)) {
                            foreach($field['group'] as $groupField) {
                                $sheet->setCellValue([$hIndex,$vIndex], ($iterator === 0) ? $groupField : '');
                                $hIndex++;
                        }
                    }
                        else if (key_exists('rows', $field)) {                            
                            foreach($field['rows'][$iterator] as $rowData) {
                                $sheet->setCellValue([$hIndex,$vIndex], $rowData);
                                $hIndex++;
                        }
                    } 
                }                
                else {
                    $sheet->setCellValue([$hIndex,$vIndex], $field);
                    $hIndex++;
                }                        
                    }
                    $vIndex++;
                }
        }
        return $vIndex;                
    }
    
    protected function renderRow(Worksheet $sheet, Request $request, int $vIndex) 
    {
        $sheet->setCellValue([1,$vIndex], $request->contract->number);
        $sheet->setCellValue([2,$vIndex], $request->contract->standNumber ? $request->contract->standNumber->number: '');
        $sheet->setCellValue([3,$vIndex], $request->contract->stand_square);
        $sheet->setCellValue([4,$vIndex], $request->contract->registration_fee);
        $sheet->setCellValue([5,$vIndex], $request->company->name);
        $sheet->setCellValue([6,$vIndex], $request->user->email);
        $sheet->setCellValue([7,$vIndex], RequestStatusHelper::getStatusName($request->status));        
    }
    
    protected function getRenderedFieldsForRow(Request $request) :array
    {
        $langCode = Yii::$app->language;
        $contract = Contracts::createDummy();
        $userIdentity = Yii::$app->user->getIdentity();  
        $formHelper = FormHelper::createViaRequest($userIdentity->getUser(), $contract,$langCode, $request); 
        $fieldsList = $formHelper->getElementsForExcel();
        
        return $fieldsList;
    }


    protected function postprocessExcel(Worksheet $sheet,int $headerVIndex, int $cellsCount,int $rowsCount) 
    {
        $borderStyle = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                
                            ],
                        ],
                    ];
        $headerBGColor = 'dbdbdb';
        $sheet->mergeCells([1,1,$cellsCount+7, 1]);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle([1,2,$cellsCount+7, $rowsCount ])->applyFromArray($borderStyle);
        $sheet->getStyle([1,2,$cellsCount+7,$headerVIndex])->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($headerBGColor);
        $sheet->getStyle([1,2,$cellsCount+7,$headerVIndex])->getFont()->setBold(true);
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }        
    }
}
