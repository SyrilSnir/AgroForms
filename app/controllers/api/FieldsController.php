<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\models\ActiveRecord\Forms\Field;
use Yii;

/**
 * Description of FieldsController
 *
 * @author kotov
 */
class FieldsController extends JsonController
{
    public $enableCsrfValidation = false;    
    
    public function actionSetDefault() 
    {
        $fieldId = Yii::$app->request->post('fieldId');
        $defaultValue = Yii::$app->request->post('defaultValue');
        $field = Field::findOne($fieldId);
        if ($field) {
            $field->setDefaultValue($defaultValue)->save();
        }
        return 'OK';
    }
}
