<?php

namespace app\core\repositories\manage\Geography;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Geography\Region;
use yii\db\ActiveRecord;

/**
 * Description of RegionRepository
 *
 * @author kotov
 */
class RegionRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Region::findOne($id)) {
            throw new NotFoundException('Регион не найден');
        }
        return $model;
    }
}
