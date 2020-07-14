<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\helpers\View;

/**
 *
 * @author kotov
 */
interface StatusHelperInterface
{
    public static function statusList(): array;
    public static function getStatusLabel(string $status):string;
    public static function getStatusName($status): string;  
    
    
}
