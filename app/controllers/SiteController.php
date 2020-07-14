<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Description of SitreController
 *
 * @author kotov
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];        
    }
    
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->response->redirect(Url::to('manage/auth'));
        }

        return Yii::$app->response->redirect(Url::to('manage'));
    }
    
    public function actionAccessDenied()
    {
        return 'Access denied';
    }
}
