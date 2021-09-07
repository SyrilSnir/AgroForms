<?php

namespace app\modules\panel\controllers\AccessRule;

use app\modules\panel\controllers\ManageController;
use Yii;
use yii\base\Action;
use yii\helpers\Url;

/**
 * Description of BaseAdminController
 *
 * @author kotov
 */
abstract class BaseAdminController extends ManageController
{
    protected $roles = ['adminMenu'];    
    
    public static function isDenyAction($rule, Action $action)
    {
        if (Yii::$app->user->isGuest) {
            return $action->controller->redirect(Url::to('/panel/auth'));
        }
        return $action->controller->redirect(Url::to('/site/access-denied'));        
    }
}
