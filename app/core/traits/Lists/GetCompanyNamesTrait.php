<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Companies\Company;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetCompanyNamesTrait
{
    public function companiesList()
    {
        return ArrayHelper::map(Company::find()->orderBy('id')->asArray()->all(),'id','name');
    }
}
