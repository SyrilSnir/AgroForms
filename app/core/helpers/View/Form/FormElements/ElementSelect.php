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
                $fieldText .=  ' - '. "{$fieldEnum->value} {$this->field->form->valute->symbol}";
            }
            $text.= '<div class="form-control">' . $fieldText .'</div>';
            
        }
        return $text  . '</div></div>';
    }

    public function getPrice(array $valuesList = []): int 
    {
        $result = 0;
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
        /** @var FieldEnum $fieldEnum */
            $fieldEnum = FieldEnum::findOne($valuesList['value']);
            if (intval($fieldEnum->value)) {
                $result = $fieldEnum->value;
            }
        }
        return $result;
    }

    public function renderPDF(array $valuesList = []): string 
    {
        $text = '<tr><td style="color:black;font-family:Verdana;font-size:10pt" colspan="2"><b>' . $this->field->name . ': </b></td><tr>';        
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
        /** @var FieldEnum $fieldEnum */
            $fieldEnum = FieldEnum::findOne($valuesList['value']);
            if ($this->isComputed()) {
                $fieldText = '<tr><td style="color:black;font-family:Verdana;font-size:10pt;padding-left:24pt">' . $fieldEnum->name;
                $fieldText .=   '</td><td style="color:black;font-family:Verdana;font-size:10pt;text-align:right">'. "{$fieldEnum->value} {$this->field->form->valute->symbol}";
            } else {
                 $fieldText = '<tr><td colspan="2" style="color:black;font-family:Verdana;font-size:10pt;padding-left:24pt">' . $fieldEnum->name;                
            }
            $text.= $fieldText .'</td></tr>';
            
        }
        return $text;
    }

}
