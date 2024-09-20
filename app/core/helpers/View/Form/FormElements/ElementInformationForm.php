<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\helpers\View\Form\ExcelHeaderView;

/**
 * Description of ElementInformationForm
 *
 * @author kotov
 */
class ElementInformationForm extends FormElement implements CountableElementInterface
{    
    public function getExcelHeader($equipment = false): ExcelHeaderView
    {
        $result = new ExcelHeaderView($this->getField()->name, $this->getLenght(),false,true);
        $result->addChild(new ExcelHeaderView('Сайт',1));
        $result->addChild(new ExcelHeaderView('Email',1));
        $result->addChild(new ExcelHeaderView('Телефон',1));
        return $result;
    }
    
    public function getExcelValue(array $valuesList = []): array|string
    {    
        if (key_exists('value', $valuesList) && !empty($valuesList['value'])) {
            return ['rows' =>  $valuesList['value']];
        }
        return [];
    }
    
    public function getLenght($equipment = false): int
    {
        return 3;
    }
    
    protected function transformData(array $fieldList, array $valuesList): array
    {
        $data = parent::transformData($fieldList, $valuesList);
        if (key_exists('value', $valuesList)) {
            $data['value'] = $valuesList['value'];
        }                        
        return $data;
    }
    public function getPrice(array $valuesList = []): int
    {
        if (!$this->isComputed() || !key_exists('value', $valuesList)) {
            return 0;
        }
        $params = $this->getParameters();
        $freeCount = $params['freeCount'];
        $unitPrice = $params['unitPrice'];
        $blocksCount = count($valuesList['value']);
        if ($unitPrice <= 0 || $blocksCount <= $freeCount) {            
            return 0;
        }
        return $unitPrice * ($blocksCount - $freeCount);
    }

    public function renderHtml(array $valuesList = []): string
    {
        if (key_exists('value', $valuesList) && !empty($valuesList['value'])) {
            return $this->view->renderFile('@fields/information.php',[
                'values' => $valuesList['value'],
                'price' => $this->getPrice($valuesList),
                'isComputed' => $this->isComputed(),
                'valute' => $this->field->form->valute->symbol,
                'title' => $this->field->name,                
            ]);
            }
        return '';
    }

    public function renderPDF(array $valuesList = []): string
    {
        if (key_exists('value', $valuesList) && !empty($valuesList['value'])) {
            return $this->view->renderFile('@fields/information__pdf.php',[
                'values' => $valuesList['value'],
                'price' => $this->getPrice($valuesList),
                'isComputed' => $this->isComputed(),
                'valute' => $this->field->form->valute->symbol,
                'title' => $this->field->name,                
            ]);
            }
        return '';       
    }
}
