<?php

namespace app\core\helpers\View\Form\FormElements;

use app\models\ActiveRecord\Forms\FieldEnum;

/**
 * Description of Selector
 *
 * @author kotov
 */
class ElementSelect extends FormElement implements CountableElementInterface
{
    protected function transformData(array $fieldList,  array $valuesList = []): array
    {
        $fieldList = parent::transformData($fieldList, $valuesList);        
        $fieldList['enumsList'] = $this->fieldEnumProvider->getEnumsList($this->field);
        if ($this->isComputed()) {
            $fieldElement = $this;
            $fieldList['enumsList'] = array_map(function ($el) use ($fieldElement){
                $el['value'] = $fieldElement->modifyPrice($el['value']);
                return $el;
            }, $fieldList['enumsList']);
        }
        if (!empty($valuesList)) {
            $fieldList['value'] = $valuesList['value'];
        }        
        return $fieldList;
    }

    //put your code here
    public function renderHtml(array $valuesList = []): string
    {
        $text = '<div class="input__field"><div class="field__name">' . $this->field->name . ':</div><div class="field__value" style="width:100%">';        
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
        /** @var FieldEnum $fieldEnum */
            $fieldEnum = FieldEnum::findOne($valuesList['value']);
            $fieldText = $fieldEnum->name;
            if ($this->isComputed()) {
                $val = $this->modifyPrice($fieldEnum->value);
                $fieldText .=  ' - '. "{$val} {$this->field->form->valute->symbol}";
            }
            $text.= '<div class="form-control">' . $fieldText .'</div>';
            
        }
        return $text  . '</div></div>';
    }
    
    public function getExcelValue(array $valuesList = []): array|string
    {
        $fieldText = '';
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
        /** @var FieldEnum $fieldEnum */
            $fieldEnum = FieldEnum::findOne($valuesList['value']);
            if ($this->isComputed()) {
                $val = $this->modifyPrice($fieldEnum->value);
                $fieldText = "{$fieldEnum->name} - {$val} {$this->field->form->valute->symbol}";
            } else {
                 $fieldText = $fieldEnum->name;
            }
        }
        return $fieldText;        
    }

    public function getPrice(array $valuesList = []): int 
    {
        $result = 0;
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
        /** @var FieldEnum $fieldEnum */
            $fieldEnum = FieldEnum::findOne($valuesList['value']);
            if (intval($fieldEnum->value)) {
                $result = $this->modifyPrice($fieldEnum->value);
            }
        }
        return $result;
    }

    public function renderPDF(array $valuesList = []): string 
    {
        $text = '<tr><td style="color:black;font-family:Verdana;font-size:10pt"><b>' . $this->field->name . ': </b></td>';      
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
        /** @var FieldEnum $fieldEnum */
            $fieldEnum = FieldEnum::findOne($valuesList['value']);
            if ($this->isComputed()) {
                $val = $this->modifyPrice($fieldEnum->value);
                $fieldText = '<td style="color:black;font-family:Verdana;font-size:10pt;text-align:right">' . $fieldEnum->name;
                $fieldText .=   " - {$val} {$this->field->form->valute->symbol}</td>";
            } else {
                 $fieldText = '<td colspan="2" style="color:black;font-family:Verdana;font-size:10pt;padding-left:24pt">' . $fieldEnum->name .'</td>';                
            }
            $text.= $fieldText .'</tr>';
            
        }
        return $text;
    }

}
