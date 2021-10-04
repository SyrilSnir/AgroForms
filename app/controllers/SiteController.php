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
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception,'message' => $exception->getMessage()]);
        }
    }
    
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->response->redirect(Url::to('panel/auth'));
        }

        return Yii::$app->response->redirect(Url::to('panel'));
    }
    
    public function actionAccessDenied()
    {
        return 'Access denied';
    }
}
