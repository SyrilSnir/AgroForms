<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementCheckbox
 *
 * @author kotov
 */
class ElementCheckbox extends FormElement
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
        if (!empty($valuesList)) {
            $fieldList['value'] = $valuesList['value'];
            $fieldList['checked'] = $valuesList['checked'];
        }
        return $fieldList;
    }

}
