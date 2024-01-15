<?php

namespace app\core\repositories\manage\Nomenclature;

use app\core\repositories\manage\DataManipulationTrait;
use app\models\ActiveRecord\Nomenclature\EquipmentPrices;

/**
 * Description of EquipmentPricesRepository
 *
 * @author kotov
 */
class EquipmentPricesRepository
{
    use DataManipulationTrait;
    
    public function get(int $exhibitionId,int $equipmentId) : ?EquipmentPrices
    {
        return EquipmentPrices::findOne(['exhibition_id' => $exhibitionId, 'eqipment_id' => $equipmentId]);
    }
}
