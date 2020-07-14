<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Description of FormController
 *
 * @author kotov
 */
abstract class FormController extends JsonController
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['member'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'send-form' => ['POST'],
                ]
            ],
        ];
    }

    public function init() 
    {
        parent::init();
        $this->enableCsrfValidation = false;
    }
    abstract public function actionGetForm() ;    
    abstract public function actionSendForm() ;    
}
