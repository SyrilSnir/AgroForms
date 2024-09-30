<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\helpers\View\Form\BaseFormHelper;
use app\core\helpers\View\Form\ExcelHeaderView;
use app\models\ActiveRecord\Geography\Country;

/**
 * Description of ElementAddressForm
 *
 * @author kotov
 */
class ElementAddressBlock extends FormElement implements CountableElementInterface
{    
    public function getExcelHeader($equipment = false): ExcelHeaderView
    {
        $result = new ExcelHeaderView($this->getField()->name, $this->getLenght(),false,true);
        $result->addChild(new ExcelHeaderView('Страна',1));
        $result->addChild(new ExcelHeaderView('Регион',1));
        $result->addChild(new ExcelHeaderView('Город',1));
        $result->addChild(new ExcelHeaderView('Адрес',1));
        $result->addChild(new ExcelHeaderView('Индекс',1));
        return $result;
    }
    
    public function getExcelValue(array $valuesList = [],$equipment = false): array|string
    {    
        if (key_exists('value', $valuesList) && !empty($valuesList['value'])) {
            return ['rows' =>  $valuesList['value']];
        }
        return [];
    }
    
    public function getLenght($equipment = false): int
    {
        return 5;
    }
    
    protected function transformData(array $fieldList, array $valuesList): array
    {
        $data = parent::transformData($fieldList, $valuesList);
        if (key_exists('value', $valuesList)) {
            $data['value'] = $valuesList['value'];
        } 
        if ($this->field->label_id) {
            $data['label'] = $this->field->label->code;
        } else {
            $data['label'] = BaseFormHelper::COMPANY_ADDRESS_RUS;
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
         //   dump($valuesList); die;
            $this->transformValues($valuesList);
            return $this->view->renderFile('@fields/address.php',[
                'values' => $valuesList['value'],
                'price' => $this->getPrice($valuesList),
                'isComputed' => $this->isComputed(),
                'valute' => $this->field->form->valute->symbol,
                'title' => $this->field->name,
            ]);
            }
        return '';
    }

    private function transformValues(&$valuesList)
    {
        foreach ($valuesList['value'] as &$element) {
            $country = $element['country'];
            if (is_numeric($country)) {
                $country = Country::findOne($country);
                $element['country'] = $country->name;
            }
        }
    }
    
    public function renderPDF(array $valuesList = []): string
    {
        if (key_exists('value', $valuesList) && !empty($valuesList['value'])) {
            $this->transformValues($valuesList);            
            return $this->view->renderFile('@fields/address__pdf.php',[
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
