<?php

namespace app\core\repositories\readModels\Contracts;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Contract\StandNumber;

/**
 * Description of StandNumberReadRepository
 *
 * @author kotov
 */
class StandNumberReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return StandNumber::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
