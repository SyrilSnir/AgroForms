<?php

namespace app\modules\manage\controllers\AccessRule;

use app\modules\manage\controllers\ManageController;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Description of BaseAdminController
 *
 * @author kotov
 */
abstract class BaseAdminController extends ManageController
{
    

        
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['adminMenu']
                    ]  
                ],
                'denyCallback' => function($rule, $action) {
                        if (\Yii::$app->user->isGuest) {
                            return $action->controller->redirect(Url::to('/manage/auth'));
                        }
                        return $action->controller->redirect(Url::to('/site/access-denied'));
                },
            ]
        ];
    }
}
