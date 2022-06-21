<?php

namespace app\modules\panel\controllers;

use app\controllers\actions\MainAction;
use app\controllers\actions\MemberMainAction;
use app\core\manage\Auth\Rbac;
use app\modules\panel\controllers\AccessRule\BaseController;
use Yii;

/**
 * Description of MainController
 *
 * @author kotov
 */
class MainController extends BaseController
{    
    public function actions(): array
    {
        if (Yii::$app->user->can(Rbac::PERMISSION_MEMBER_MENU)) {
            $actionClass = MemberMainAction::class;
        } else {
            $actionClass = MainAction::class;
        }
        return [
            'index' => $actionClass,
        ];
    }

    public function __construct(
            $id, 
            $module, 
            $config = []
            )
    {      
        parent::__construct($id, $module, $config);
    }
}
