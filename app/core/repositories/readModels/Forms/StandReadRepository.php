<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\Stand;

/**
 * Description of StandReadRepository
 *
 * @author kotov
 */
class StandReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Stand::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
