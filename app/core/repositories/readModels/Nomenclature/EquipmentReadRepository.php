<?php

namespace app\core\repositories\readModels\Nomenclature;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Nomenclature\Equipment;

/**
 * Description of EquipmentReadRepository
 *
 * @author kotov
 */
class EquipmentReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Equipment::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
