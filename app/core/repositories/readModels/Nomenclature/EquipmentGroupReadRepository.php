<?php

namespace app\core\repositories\readModels\Nomenclature;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Nomenclature\EquipmentGroup;

/**
 * Description of CategoryReadRepository
 *
 * @author kotov
 */
class EquipmentGroupReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return EquipmentGroup::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
