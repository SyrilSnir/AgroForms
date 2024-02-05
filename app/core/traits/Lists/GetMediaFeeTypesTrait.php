<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Contract\MediaFeeTypes;
use yii\helpers\ArrayHelper;

/**
 * Description of GetMediaFeeTypesTrait
 *
 * @author kotov
 */
trait GetMediaFeeTypesTrait
{
    public function mediaFeeTypesList():array
    {
        return ArrayHelper::map(MediaFeeTypes::find()->orderBy('name')->asArray()->all(),'id','name');         
    }
}
