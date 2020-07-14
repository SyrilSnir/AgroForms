<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetFormsListTrait
{
    public function formsList():array
    {
        return ArrayHelper::map(Form::find()->andWhere(['!=', 'form_type_id' , FormType::SPECIAL_STAND_FORM])->orderBy('id')->asArray()->all(),'id','name'); 
        
    }
}
