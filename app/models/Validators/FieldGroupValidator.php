<?php

namespace app\models\Validators;

use app\models\ActiveRecord\Forms\ElementType;
use yii\validators\Validator;

/**
 * Description of FieldGroupValidator
 *
 * @author kotov
 */
class FieldGroupValidator extends Validator
{
    public function validateAttribute($model, $attribute) 
    {
        if (!property_exists($model, 'elementTypeId')) {
            $this->addError($model, $attribute, 'Данный валидатор поддерживается только объектом FieldForm');
            return ;
        }
        if ($attribute != 'fieldGroupId') {
            $this->addError($model, $attribute, 'Данный валидатор может быть установлен только на идентификатор группы полей');
            return ;            
        }
        $groupId = $model->$attribute;
        if ($model->elementTypeId == ElementType::ELEMENT_GROUP && $groupId != 0) {
            $this->addError($model, $attribute, 'Вложенные группы не поддерживаются');
        }
    }
    //put your code here
}
