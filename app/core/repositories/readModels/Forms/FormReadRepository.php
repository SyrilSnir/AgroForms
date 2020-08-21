<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;

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
    
    public static function findStandForm()
    {
        return Form::find()
                ->andWhere(['form_type_id' => FormType::SPECIAL_STAND_FORM])->one();
    }
}
