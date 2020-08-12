<?php

namespace app\core\helpers\Utils;

/**
 * Description of DateHelper
 *
 * @author kotov
 */
class DateHelper
{
    public static function timestampToDate(int $timestamp,string $format = 'd.m.Y'):string
    {
        $dt = new \DateTime();
        return $dt->setTimestamp($timestamp)->format($format);
    }
}
