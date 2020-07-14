<?php

namespace app\core\helpers\View;

/**
 * Description of StatusHelper
 *
 * @author kotov
 */
abstract class StatusHelper implements StatusHelperInterface
{
    public static function getStatusName($status): string
    {
       return ArrayHelper::getValue(self::statusList(), $status);         
    }    
}
