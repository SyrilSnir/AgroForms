<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\FieldGroup;

/**
 * Description of FieldGroupReadRepository
 *
 * @author kotov
 */
class FieldGroupReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return FieldGroup::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
