<?php

namespace app\core\repositories\readModels\Exhibition;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Exhibition\Exhibition;

/**
 * Description of ExhibitionReadRepository
 *
 * @author kotov
 */
class ExhibitionReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Exhibition::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
