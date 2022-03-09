<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\traits\Data\EquipmentValuesPrepareTrait;

/**
 * Description of ElementAdditionEquipmentBlock
 *
 * @author kotov
 */
class ElementAdditionEquipmentBlock extends FormElement
{
    use EquipmentValuesPrepareTrait;
    //put your code here
    public function renderHtml(array $valuesList = []): string
    {
        if (!key_exists('value', $valuesList)) {
            return '';
        }
        $eqValues = $this->processEquipmentValues($valuesList['value']);
        return \Yii::$app->view->renderFile('@blocks/equipment.list.php' ,[
            'values' => $eqValues,
            'valute' => $this->field->form->valute->symbol
        ]);
    }
    
    protected function transformData(array $fieldList, array $valuesList = []): array
    {        
        if (key_exists('value', $valuesList)) {
            $fieldList['value'] = $this->processEquipmentValues($valuesList['value']);
        }
        return $fieldList;
    }

}
