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
        $price = $this->getPrice($valuesList);
        if ($price > 0 ) {
            $digitPrice = $this->getDigitPrice();
            $addDigit = $this->getAdditionDigits($valuesList);
            $text .= "<div style=\"margin-top:5px\">Дополнительно: $addDigit знаков x $digitPrice{$this->field->form->valute->symbol} = $price {$this->field->form->valute->symbol}</div>";
        }
        $text.= '</div>';
        return $text  . '</div>';
    }

    public function renderPDF(array $valuesList = []): string
    {
        $text = '<tr style="border:none;border-bottom:1px solid #ededed"><td style="color:black;font-family:Verdana;font-size:10pt;font-weight:bold;text-align:left;"><b>' . $this->field->name . ': </b></td>';
        $text .= '<td style="text-align: right;color:black;font-family:Verdana;font-size:10pt;padding-left:24pt">';
        if (key_exists('value', $valuesList)) {
            $text.= $valuesList['value'];
        }
        $price = $this->getPrice($valuesList);
        if ($price > 0 ) {
            $digitPrice = $this->getDigitPrice();
            $addDigit = $this->getAdditionDigits($valuesList);
            $text .= "<div style=\"font-family:Verdana;font-size:8pt;font-weight:lighten;text-align:right;\">Дополнительно: $addDigit знаков x $digitPrice{$this->field->form->valute->symbol} = $price {$this->field->form->valute->symbol}</div>";
        }
        return $text.= "</td></tr>";;
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
        $fieldList['parameters'] = $this->buildParameters($fieldList);
        if (!empty($valuesList)) {
            $fieldList['value'] = $valuesList['value'];
        }
        return $fieldList;
    }
    
    public function getPrice(array $valuesList = []): int
    {
        $digitPrice = $this->getDigitPrice();
        return $digitPrice * ($this->getAdditionDigits($valuesList)); 
    }
    
    private function getAdditionDigits(array $valuesList = []): int
    {
        $val = '';
        $freeDigits = $this->getFreeDigits();
        if (key_exists('value', $valuesList)) {
            $val = trim($valuesList['value']);
        }
        $digitCount = mb_strlen($val);
        if ($digitCount <= $freeDigits) {
            return 0;
        }        
        return $digitCount - $freeDigits;
    }  
    
    private function getFreeDigits(): int
    {
        $params = $this->getParameters();        
        return (int) $params['freeDigitCount'];
    }
    
    private function getDigitPrice(): int
    {
        $params = $this->getParameters();        
        return (int) $params['digitPrice'];
    }

    public function isComputed(): bool
    {
        return true;
    }

}
