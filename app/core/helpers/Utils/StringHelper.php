<?php

namespace app\core\helpers\Utils;

/**
 * Description of StringHelper
 *
 * @author kotov
 */
class StringHelper
{
    public static function extractNumberFromString(string $str): int
    {
        $str = (int) preg_replace('#[^\d]#','' , $str);
        return $str;
    }
}
