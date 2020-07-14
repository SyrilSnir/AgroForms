<?php

namespace app\core\repositories\readModels\Nomenclature;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Nomenclature\Unit;

/**
 * Description of UnitReadRepository
 *
 * @author kotov
 */
class UnitReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Unit::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
