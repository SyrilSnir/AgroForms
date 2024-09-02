<?php

namespace app\core\helpers\Utils;

/**
 * Description of ArrayHelper
 *
 * @author kotov
 */
class ArrayHelper
{
    static function caseInsensitiveSort(array &$array):void 
    {
         usort($array,  function($a, $b) {
            $la = mb_convert_case($a, MB_CASE_LOWER);
            $lb = mb_convert_case($b, MB_CASE_LOWER);
            if ($la == $lb) {
                return ($a <= $b) ? 0 : 1;
            }
            return ($la < $lb) ? -1 : 1;
        });
    }
}
