<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\controllers\api;

use app\controllers\JsonController;

/**
 * Description of EnumElementsController
 *
 * @author kotov
 */
class EnumElementsController extends JsonController
{
    public function actionEdit(int $id) 
    {
        $fieldEnum = \app\models\ActiveRecord\Forms\FieldEnum::findOne($id);
        $editedFields = \Yii::$app->request->post('FieldEnum');
        if (!empty($editedFields)) {
            $editedField['FieldEnum'] = current($editedFields);
        }
        $fieldEnum->load($editedField);
        $fieldEnum->save(false);
        return ['output'=>'', 'message'=>''];
    }
}
