<?php

namespace app\core\helpers\View\Form\FormElements;

use app\models\ActiveRecord\Forms\FieldEnum;

/**
 * Description of Selector
 *
 * @author kotov
 */
class ElementSelect extends FormElement
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

}
