<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\manage\Auth\Rbac;
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
                        'roles' => [Rbac::PERMISSION_MEMBER_MENU, Rbac::PERMISSION_ADMINISTRATOR_MENU, Rbac::PERMISSION_ORGANIZER_MENU],
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
    abstract public function actionGetForm($contractId) ;    
    abstract public function actionSendForm() ;    
}
