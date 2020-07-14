<?php

namespace app\core\repositories\manage\Nomenclature;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Nomenclature\EquipmentGroup;
use yii\db\ActiveRecord;

/**
 * Description of EquipmentGroupRepository
 *
 * @author kotov
 */
class EquipmentGroupRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = EquipmentGroup::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $model;
    }
}
