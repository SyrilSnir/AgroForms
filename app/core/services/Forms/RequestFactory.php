<?php

namespace app\core\services\Forms;

/**
 * Description of RequestFactory
 *
 * @author kotov
 */
class RequestFactory
{
    public static function getStandService():StandService
    {
        return new StandService();
    }
}
