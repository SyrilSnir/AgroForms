<?php

namespace app\modules\panel\controllers\AccessRule;

use app\modules\panel\controllers\ManageController;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Description of BaseMemberController
 *
 * @author kotov
 */
class BaseMemberController extends ManageController
{
    protected $roles = ['memberMenu'];

    public static function isDenyAction($rule, Action $action)
    {
        if (Yii::$app->user->isGuest) {
            return $action->controller->redirect(Url::to('/panel/auth'));
        }
        return $action->controller->redirect(Url::to('/site/access-denied'));        
    }    
}
