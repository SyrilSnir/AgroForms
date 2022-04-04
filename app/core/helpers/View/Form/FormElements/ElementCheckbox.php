<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementCheckbox
 *
 * @author kotov
 */
class ElementCheckbox extends FormElement implements CountableElementInterface
{
    public function renderHtml(array $valuesList = []): string
    {
        if (key_exists('checked', $valuesList) && $valuesList['checked'] == true) {
            $text = '<div class="input__field"><div class="field__name">' . $this->field->name .  ':</div>'; 
            if (key_exists('value', $valuesList) && $valuesList['value'] > 0) {
                $text .= '<div class="field__value form-control">' . $valuesList['value'] . ' '. $this->field->form->valute->symbol . '</div>';
            }
            return $text . '</div>';
        }
        return '';
    }
    
    protected function transformData(array $fieldList, array $valuesList = []): array
    {    
        $fieldList = parent::transformData($fieldList, $valuesList);
        if (!empty($valuesList) && key_exists('checked', $valuesList)) {
            $fieldList['value'] = $valuesList['value'];
            $fieldList['checked'] = $valuesList['checked'];
        }
        return $fieldList;
    }

    public function getPrice(array $valuesList = []): int 
    {
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
            return $valuesList['value'];
        }
        return 0;
    }

    public function renderPDF(array $valuesList = []): string 
    {
        if (key_exists('checked', $valuesList) && $valuesList['checked'] == true) {
            $text = '<div style="position:relative;"><span style="font-weight:bold">' . $this->field->name .  ': </span>'; 
            if (key_exists('value', $valuesList) && $valuesList['value'] > 0) {
                $text .= '<span>' . $valuesList['value'] . ' '. $this->field->form->valute->symbol . '</span>';
            }
            return $text . '</div>';
        }
        return '';
    }

}
