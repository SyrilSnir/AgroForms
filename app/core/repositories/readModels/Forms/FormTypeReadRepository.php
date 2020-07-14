<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\FormType;

/**
 * Description of FormTypeReadRepository
 *
 * @author kotov
 */
class FormTypeReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return FormType::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
