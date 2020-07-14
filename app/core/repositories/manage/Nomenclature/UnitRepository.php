<?php

namespace app\core\repositories\manage\Nomenclature;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Nomenclature\Unit;
use yii\db\ActiveRecord;

/**
 * Description of UnitRepository
 *
 * @author kotov
 */
class UnitRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Unit::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $model;
    }
}
