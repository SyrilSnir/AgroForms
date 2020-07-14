<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits;

/**
 *
 * @author kotov
 */
trait SingltoneTrait
{
    private static $instance = null;

    private function __construct() { }
    private function __clone() { }
    private function __wakeup() { }

    public static function getInstance() {
        return 
        self::$instance===null
                ? self::$instance = new static()
                : self::$instance;
    }
    
}
