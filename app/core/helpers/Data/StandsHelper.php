<?php

namespace app\core\helpers\Data;

use app\models\ActiveRecord\Forms\Stand;
use yii\helpers\ArrayHelper;

/**
 * Description of StandsHelper
 *
 * @author kotov
 */
class StandsHelper
{
    public static function standsList() :array 
    {
        return ArrayHelper::toArray(Stand::find()->all());
    }
}
