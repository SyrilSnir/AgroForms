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
                ->andFilterWhere(['form_id' => $formId])
                ->andFilterWhere(['deleted' => false])
                ->orderBy(['order' => SORT_ASC])
                ->asArray()
                ->all();        
    }
}
