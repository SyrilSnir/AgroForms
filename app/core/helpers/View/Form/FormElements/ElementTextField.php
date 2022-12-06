<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of TextField
 *
 * @author kotov
 */
class ElementTextField extends FormElement
{
    public function renderHtml(array $valuesList = []): string 
    {
        
        $text = '<div class="input__field"><div class="field__name">' . $this->field->name . ':</div>';
        $text .= '<div class="field__value form-control">';
        if (key_exists('value', $valuesList)) {
            $text.= $valuesList['value'];
        }
        return $text  . '</div></div>';
    }
    
    public function getExcelValue(array $valuesList = []): array|string
    {
        if (key_exists('value', $valuesList)) {
            return $valuesList['value'] ??= '';
        }
        return '';
    }


    protected function transformData(array $fieldList, array $valuesList = []): array
    {    
        $fieldList = parent::transformData($fieldList, $valuesList);
        if (key_exists('value', $valuesList)) {
            $fieldList['value'] = $valuesList['value'];
        }
        return $fieldList;
    }

    public function renderPDF(array $valuesList = []): string 
    {
        $text = '<tr style="border:none;border-bottom:1px solid #ededed"><td style="color:black;font-family:Verdana;font-size: 10pt;font-weight:bold;text-align:left;">' . $this->field->name .  ': </td>'; 
        if (key_exists('value', $valuesList)) {
            $text.= '<td style="color:black;font-family:Verdana;font-size:10pt;text-align:right">'.$valuesList['value'].'</td>';
        }
        return $text . '</tr>';       
    }

}
