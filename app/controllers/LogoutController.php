<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Description of LogoutController
 *
 * @author kotov
 */
class LogoutController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]  
                ]
            ]
        ];
    }    
    /**
    * Выход из системы
    * @return Response
    */ 
    public function actionIndex() 
    {
        Yii::$app->user->logout();
        return $this->redirect("/");
        
    }
}
