<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\Form;

/**
 * Description of FormReadRepository
 *
 * @author kotov
 */
class FormReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Form::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
