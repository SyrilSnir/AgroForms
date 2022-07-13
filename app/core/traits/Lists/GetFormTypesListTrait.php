<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Forms\FormType;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetFormTypesListTrait
{
    public function formTypesList()
    {
        return ArrayHelper::map(FormType::find()->andWhere(['!=','id', FormType::SPECIAL_STAND_FORM ])->orderBy('id')->asArray()->all(),'id','name');
    } 
}
