<?php

namespace app\core\repositories\readModels\Geography;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Geography\Region;

/**
 * Description of RegionReadRepository
 *
 * @author kotov
 */
class RegionReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Region::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
