<?php

namespace app\core\helpers\Data\Form;

use app\models\ActiveRecord\Forms\FieldGroup;
use yii\db\ActiveQuery;

/**
 * Description of FieldGroupHelper
 *
 * @author kotov
 */
class FieldGroupsHelper
{
    public static function getGroupsWithFields(int $formId = null):array
    {
        return 
            array_filter(FieldGroup::find()
                            ->with(['fields' => function (ActiveQuery $query) use ($formId) {
                                $query->andFilterWhere(['form_id' => $formId])
                                       ->orderBy(['order' => SORT_ASC]) ;
                                }]
                            )
                            ->where(['!=', 'id', FieldGroup::UNDEFINED_FIELD_GROUP ])
                            ->asArray()->all(),
                        function($element) {
                             return !empty($element['fields']);
                        });        
    }
}
