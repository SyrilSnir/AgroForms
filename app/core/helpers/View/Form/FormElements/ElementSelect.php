<?php

namespace app\core\helpers\View\Form\FormElements;

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
        return $fieldList;
    }

    //put your code here
    public function renderHtml(array $valuesList = []): string
    {
        return '';
    }

}
