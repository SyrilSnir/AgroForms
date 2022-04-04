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
                    $fieldText .=  ' - '. "{$fieldEnum->value} {$this->field->form->valute->symbol}";
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
                    $result += $fieldEnum->value;
                }
            }
        }
        return $result;
    }    
    
    public function renderPDF(array $valuesList = []): string 
    {
        $text = '<div style="position:relative;"><span style="font-weight:bold">' . $this->field->name . ': </span><div>';        
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
            foreach ($valuesList['value'] as $element) {
            /** @var FieldEnum $fieldEnum */
                $fieldEnum = FieldEnum::findOne($element);
                $fieldText = $fieldEnum->name;
                if ($this->isComputed()) {
                    $fieldText .=  ' - '. "{$fieldEnum->value} {$this->field->form->valute->symbol}";
                }
                $text.= '<div>' . $fieldText .'</div>';
            }
            
        }
        return $text  . '</div></div>';
    }    
}
