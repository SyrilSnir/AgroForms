<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementCheckNumberInput
 *
 * @author kotov
 */
class ElementCheckNumberInput extends FormElement implements CountableElementInterface
{
    public function renderHtml(array $valuesList = []): string
    {        
        $unitTitle = '';
        $fieldParams = $this->field->getFieldParams();
        if ($fieldParams->unitModel) {
            $unitTitle = ' ' . $fieldParams->unitModel->short_name;
        }

         if (key_exists('checked', $valuesList) && $valuesList['checked'] == true) {
            $text = '<div class="input__field"><div class="field__name">' . $this->field->name . ':</div>';
            if (key_exists('value', $valuesList)) {
                $valuesList['value'] = empty($valuesList['value']) ? 0 : $valuesList['value'];
                $text .= '<div class="field__value form-control">' . $valuesList['value'] . $unitTitle;
                if ($this->isComputed()) {
                    if (($price = $this->field->getPrice()) > 0) {
                        $summ = (int) $valuesList['value'] * $price;
                        $text.= ' x ' . $price . ' '. $this->field->form->valute->symbol . '=' . $summ . ' '. $this->field->form->valute->symbol;
                    } else {
                        $text.= $price . $this->field->form->valute->char_code;
                    }
                }
                $text.= '</div>';
            }
            return $text . '</div>';
         }
         return '';
    }
    
    protected function transformData(array $fieldList, array $valuesList = []): array
    {
        $fieldList['parameters'] = json_decode($fieldList['parameters']);
        if (!empty($valuesList)) {
            $fieldList['value'] = $valuesList['value'];
            $fieldList['checked'] = key_exists('checked', $valuesList) ?  $valuesList['checked'] : false;
        }
        return $fieldList;
    }

    public function getPrice(array $valuesList = []): int 
    {   
        $result = 0;
        if (key_exists('checked', $valuesList) && $valuesList['checked'] == true && key_exists('value', $valuesList)) {
            if (($price = $this->field->getPrice()) > 0) {
                $result = (int) $valuesList['value'] * $price;                
            }            
        }
        return $result;
    }

    public function renderPDF(array $valuesList = []): string 
    {
        $unitTitle = '';
        $fieldParams = $this->field->getFieldParams();
        if ($fieldParams->unitModel) {
            $unitTitle = ' ' . $fieldParams->unitModel->short_name;
        }

         if (key_exists('checked', $valuesList) && $valuesList['checked'] == true) {
            $text = '<tr style="border:none;border-bottom:1px solid #ededed"><td style="color:black;font-family:Verdana;font-size:10pt;font-weight:bold;text-align:left;">' . $this->field->name . ': </td>';
            if (key_exists('value', $valuesList)) {
                $valuesList['value'] = empty($valuesList['value']) ? 0 : $valuesList['value'];
                $text .= '<td style="color:black;font-family:Verdana;font-size:10pt;text-align:right"><b>' . $valuesList['value'] . $unitTitle . '</b>';
                if ($this->isComputed()) {
                    if (($price = $this->field->getPrice()) > 0) {
                        $summ = (int) $valuesList['value'] * $price;
                        $text.= ' x ' . $price . ' '. $this->field->form->valute->symbol . '=' . $summ . ' '. $this->field->form->valute->symbol;
                    } else {
                        $text.= $price . $this->field->form->valute->char_code;
                    }
                } else {                    
                    $text = '<tr style="border:none;border-bottom:1px solid #ededed"><td colspan="2" style="color:black;font-family:Verdana;font-size:10pt;font-weight:bold;text-align:left;">' . $this->field->name . ': </td>';
                }
                $text.= '</td>';
            }
            return $text . '</tr>';
         }
         return '';
    }

}
