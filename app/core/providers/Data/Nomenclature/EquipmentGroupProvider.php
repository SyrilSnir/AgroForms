<?php

namespace app\core\providers\Data\Nomenclature;

use app\models\ActiveRecord\Nomenclature\EquipmentGroup;

/**
 * Description of EquipmentGroupProvider
 *
 * @author kotov
 */
class EquipmentGroupProvider
{
    public function getList():array
    {
        $result = [];
        $result = EquipmentGroup::find()->asArray()->all();
        return $result;
    }
}
