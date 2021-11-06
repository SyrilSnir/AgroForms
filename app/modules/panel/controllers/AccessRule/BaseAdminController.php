<?php

namespace app\modules\panel\controllers\AccessRule;

use app\modules\panel\controllers\ManageController;

/**
 * Description of BaseAdminController
 *
 * @author kotov
 */
abstract class BaseAdminController extends ManageController
{
    protected $roles = ['adminMenu','organizerMenu'];       
}
