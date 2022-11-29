<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Forms\FieldGroup;
use yii\helpers\ArrayHelper;

/**
 * Description of GeyFieldGroupTrait
 *
 * @author kotov
 */
trait GetFieldGroupTrait
{
    public function fieldGroupList():array
    {
        return ArrayHelper::map(FieldGroup::find()->orderBy('id')->asArray()->all(),'id','name');         
    }
}
