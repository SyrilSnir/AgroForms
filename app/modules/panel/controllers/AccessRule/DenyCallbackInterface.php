<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\controllers\AccessRule;

use yii\base\Action;
use yii\filters\AccessRule;

/**
 *
 * @author kotov
 */
interface DenyCallbackInterface
{
    /**
     * 
     * @param AccessRule|null $rule
     * @param Action $action
     */
    static function isDenyAction($rule, Action $action);
}
