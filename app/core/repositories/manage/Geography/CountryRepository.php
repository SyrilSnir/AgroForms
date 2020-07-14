<?php

namespace app\core\repositories\manage\Geography;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Geography\Country;
use yii\db\ActiveRecord;

/**
 * Description of CountryRepository
 *
 * @author kotov
 */
class CountryRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Country::findOne($id)) {
            throw new NotFoundException('Страна не найдена');
        }
        return $model;
    }
}
