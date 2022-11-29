<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Contract\Hall;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetHallsListTrait
{
    public function hallsList():array
    {
        return ArrayHelper::map(Hall::find()->orderBy('id')->asArray()->all(),'id','name');         
    }
}
