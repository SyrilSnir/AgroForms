<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\FieldLabels;

/**
 * Description of FieldLabelsReadRepository
 *
 * @author kotov
 */
class FieldLabelsReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return FieldLabels::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
