<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\controllers\AccessRule;

use app\modules\panel\controllers\ManageController;
use Yii;
use yii\base\Action;
use yii\helpers\Url;


/**
 * Description of BaseManagerController
 *
 * @author kotov
 */
class BaseManagerController extends ManageController
{
    protected $roles = ['managerMenu']; 
}
