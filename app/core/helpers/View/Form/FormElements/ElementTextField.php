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
    
    protected function transformData(array $fieldList, array $valuesList = []): array
    {    
        $fieldList = parent::transformData($fieldList, $valuesList);
        if (!empty($valuesList)) {
            $fieldList['value'] = $valuesList['value'];
        }
        return $fieldList;
    }
}
