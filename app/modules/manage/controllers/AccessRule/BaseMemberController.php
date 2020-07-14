<?php

namespace app\modules\manage\controllers\AccessRule;

use app\modules\manage\controllers\ManageController;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Description of BaseMemberController
 *
 * @author kotov
 */
class BaseMemberController extends ManageController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['memberMenu']
                    ]  
                ],
                'denyCallback' => function($rule, $action) {
                        return $action->controller->redirect(Url::to('/site/access-denied'));
                },
            ]
        ];
    }
}
