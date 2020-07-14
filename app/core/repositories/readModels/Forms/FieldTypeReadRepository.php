<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\FieldType;

/**
 * Description of FieldTypeReadRepository
 *
 * @author kotov
 */
class FieldTypeReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return FieldType::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
