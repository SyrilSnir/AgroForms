<?php

namespace app\core\repositories\readModels\Geography;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Geography\Country;

/**
 * Description of CountryReadRepository
 *
 * @author kotov
 */
class CountryReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Country::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
