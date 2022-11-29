<?php

namespace app\core\repositories\readModels\Contracts;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Contract\Hall;

/**
 * Description of HallReadRepository
 *
 * @author kotov
 */
class HallReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Hall::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
