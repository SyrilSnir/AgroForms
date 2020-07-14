<?php

namespace app\core\repositories\manage\Nomenclature;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Nomenclature\Equipment;
use yii\db\ActiveRecord;

/**
 * Description of EquipmentRepository
 *
 * @author kotov
 */
class EquipmentRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Equipment::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $model;
    }
}
