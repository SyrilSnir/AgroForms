<?php

namespace app\core\helpers\View\Form\FormElements;

use app\models\ActiveRecord\Forms\FieldEnum;

/**
 * Description of ElementSelectMultiple
 *
 * @author kotov
 */
class ElementSelectMultiple extends ElementSelect
{
    public function renderHtml(array $valuesList = []): string 
    {
        $text = '<div class="input__field"><div class="field__name">' . $this->field->name . ':</div><div class="field__value" style="width:100%">';        
        if (key_exists('value', $valuesList) && is_array($valuesList['value'])) {
            foreach ($valuesList['value'] as $element) {
            /** @var FieldEnum $fieldEnum */                
                $fieldEnum = FieldEnum::findOne($element);
                $fieldText = $fieldEnum->name;
                if ($this->isComputed()) {
                    $val = $this->modifyPrice($fieldEnum->value);
                    $fieldText .=  ' - '. "{$val} {$this->field->form->valute->symbol}";
                }                
                //if ($fieldEnum && floatval($fieldEnum->value)) {                                                      }
                $text.= '<div class="form-control">' . $fieldText . '</div>';
            }
        }
        return $text  . '</div></div>';
    }
    
    public function getPrice(array $valuesList = []): int 
    {
        $result = 0;
        if (key_exists('value', $valuesList) && is_array($valuesList['value'])) {
            foreach ($valuesList['value'] as $element) { 
            /** @var FieldEnum $fieldEnum */
                $fieldEnum = FieldEnum::findOne($element);
                if (intval($fieldEnum->value)) {
                    $val = $this->modifyPrice($fieldEnum->value);
                    $result += $val;
                }
            }
        }
        return $result;
    }  
    
    public function getExcelValue(array $valuesList = []): array|string
    {
        $fieldText = '';
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
        /** @var FieldEnum $fieldEnum */
            foreach ($valuesList['value'] as $element) {            
                $fieldEnum = FieldEnum::findOne($element);
                if ($this->isComputed()) {
                    $val = $this->modifyPrice($fieldEnum->value);
                    $fieldText.= "{$fieldEnum->name} - {$val} {$this->field->form->valute->symbol}";
                } else {
                     $fieldText.= $fieldEnum->name;
                }
                $fieldText.=',';
            }
        }
        return trim($fieldText,',');
    }    
    
    public function renderPDF(array $valuesList = []): string 
    {
        $text = '<tr><td style="color:black;font-family:Verdana;font-size:10pt" colspan="2"><b>' . $this->field->name . ': </b></td><tr>';        
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
            foreach ($valuesList['value'] as $element) {
            /** @var FieldEnum $fieldEnum */
                $fieldEnum = FieldEnum::findOne($element);
                if ($this->isComputed()) {
                    $val = $this->modifyPrice($fieldEnum->value);
                    $fieldText = '<tr><td style="color:black;font-family:Verdana;font-size:10pt;padding-left:24pt">' . $fieldEnum->name;
                    $fieldText .=  '</td><td style="color:black;font-family:Verdana;font-size:10pt;text-align:right">'. "{$val} {$this->field->form->valute->symbol}";
                } else {
                    $fieldText = '<tr><td colspan="2" style="color:black;font-family:Verdana;font-size:10pt;padding-left:24pt">' . $fieldEnum->name;
                    
                }
                $text.= $fieldText .'</td></tr>';
            }
            
        }
        return $text;
    }    
}
