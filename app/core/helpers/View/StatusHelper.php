<?php

namespace app\core\helpers\View;

use yii\helpers\ArrayHelper;

/**
 * Description of StatusHelper
 *
 * @author kotov
 */
abstract class StatusHelper implements StatusHelperInterface
{
    public static function getStatusName($status): string
    {
       return ArrayHelper::getValue(static::statusList(), $status);         
    }    
}
