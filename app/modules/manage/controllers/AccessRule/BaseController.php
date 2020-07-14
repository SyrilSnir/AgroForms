<?php

namespace app\modules\manage\controllers\AccessRule;

use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Description of BaseController
 *
 * @author kotov
 */
class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]  
                ],
                'denyCallback' => function($rule, $action) {
                        return $action->controller->redirect(Url::to('/site/access-denied'));
                },
            ]
        ];
    }
}
