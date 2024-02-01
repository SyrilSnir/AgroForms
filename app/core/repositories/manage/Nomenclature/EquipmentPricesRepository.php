<?php

namespace app\core\repositories\manage\Nomenclature;

use app\core\repositories\manage\DataManipulationTrait;
use app\models\ActiveRecord\Nomenclature\EquipmentPrices;
use yii\db\ActiveRecord;

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
        return EquipmentPrices::findOne(['exhibition_id' => $exhibitionId, 'equipment_id' => $equipmentId]);
    }
    
    public function remove(ActiveRecord $model)
    {
        /** @var EquipmentPrices $model */        
        $model->deleted = true;
        $model->save();
    }
}
