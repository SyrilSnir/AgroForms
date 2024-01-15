<?php

namespace app\modules\panel\controllers;

use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Description of BaseAdminController
 *
 * @author kotov
 */
abstract class BaseAdminController extends Controller
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
                        return $action->controller->redirect(Url::to('/panel/auth'));
                },
            ]
        ];
    }
}
