<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\models\ActiveRecord\Forms\FieldEnum;
use Yii;

/**
 * Description of ParametersController
 *
 * @author kotov
 */
class ParametersController extends JsonController
{
    public function actionSaveEnumsList()
    {
        $this->saveToSession(FieldEnum::SESSION_IDENTIFIER);
    }

    protected function saveToSession(string $sessionIdentifier) 
    {
        $list = Yii::$app->request->post('list');
        if (!is_array($list)) {
            Yii::$app->session->set($sessionIdentifier, []);
        } else {
            Yii::$app->session->set($sessionIdentifier, $list);
        }  
    }    
}
