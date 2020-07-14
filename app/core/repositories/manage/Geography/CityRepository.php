<?php

namespace app\core\repositories\manage\Geography;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Geography\City;
use yii\db\ActiveRecord;

/**
 * Description of CityRepository
 *
 * @author kotov
 */
class CityRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = City::findOne($id)) {
            throw new NotFoundException('Город не найден');
        }
        return $model;
    }

}
