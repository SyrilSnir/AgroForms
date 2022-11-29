<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Contract\StandNumber;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetStandNumbersListTrait
{
    public function standNumbersList():array
    {
        return ArrayHelper::map(StandNumber::find()->orderBy('id')->asArray()->all(),'id','number');         
    }
}
