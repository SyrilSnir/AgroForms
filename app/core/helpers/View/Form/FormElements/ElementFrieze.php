<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementFrieze
 *
 * @author kotov
 */
class ElementFrieze extends FormElement implements CountableElementInterface
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

    public function renderPDF(array $valuesList = []): string
    {
        $text = '<tr style="border:none;border-bottom:1px solid #ededed"><td style="color:black;font-family:Verdana;font-size:10pt;font-weight:bold;text-align:left;"><b>' . $this->field->name . ': </b></td>';
        $text .= '<td style="text-align: right;color:black;font-family:Verdana;font-size:10pt;padding-left:24pt">';
        if (key_exists('value', $valuesList)) {
            $text.= $valuesList['value'];
        }
        return $text  . '</td></tr>';         
    }

    
    protected function transformData(array $fieldList, array $valuesList = []): array
    {
        $fieldList['parameters'] = $this->buildParameters($fieldList);
        if (!empty($valuesList)) {
            $fieldList['value'] = $valuesList['value'];
        }
        return $fieldList;
    }
    
    public function getPrice(array $valuesList = []): int
    {
        $params = $this->getParameters();
        $val = trim($valuesList['value']);
        $freeDigits = (int) $params['freeDigitCount'];
        $digitPrice = (int) $params['digitPrice'];
        $digitCount = mb_strlen($val);
        if ($digitCount <= $freeDigits) {
            return 0;
        }
        return $digitPrice * $digitCount; 
    }
    
    public function isComputed(): bool
    {
        return true;
    }

}
