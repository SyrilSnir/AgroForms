<?php

namespace app\core\repositories\readModels\Geography;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Geography\City;

/**
 * Description of CityReadRepository
 *
 * @author kotov
 */
class CityReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return City::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
