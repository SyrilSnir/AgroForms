<?php

namespace app\core\repositories\readModels\Nomenclature;

use app\models\ActiveRecord\Nomenclature\EquipmentPrices;

/**
 * Description of EquipmentPriceReadRepository
 *
 * @author kotov
 */
class EquipmentPriceReadRepository
{
    public static function findByIds($exhibitionId, $equipmentId)
    {
        return EquipmentPrices::find()
            ->andWhere(['equipment_id' => $equipmentId])
            ->andWhere(['exhibition_id' => $exhibitionId])
            ->one();
    }
}
