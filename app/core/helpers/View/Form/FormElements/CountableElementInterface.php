<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

namespace app\core\helpers\View\Form\FormElements;

/**
 *
 * @author kotov
 */
interface CountableElementInterface 
{
    public function getPrice(array $valuesList = []): int;
}
