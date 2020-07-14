<?php

namespace app\core\helpers\Data\Form;

use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldGroup;

/**
 * Description of FieldsHelper
 *
 * @author kotov
 */
class FieldsHelper
{
    
    public static function getUncategorizedFields(int $formId = null):array
    {
        return Field::find()
                ->where(['field_group_id' => FieldGroup::UNDEFINED_FIELD_GROUP])
                ->andFilterWhere(['form_id' => $formId])
                ->orderBy(['order' => SORT_ASC])
                ->asArray()
                ->all();        
    }
}
