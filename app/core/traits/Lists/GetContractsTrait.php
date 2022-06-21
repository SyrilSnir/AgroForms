<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Contract\Contracts;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetContractsTrait 
{
    public function contractsList()
    {
        return ArrayHelper::map(Contracts::find()->orderBy('number')->asArray()->all(), 'id', 'number');
    }
}
