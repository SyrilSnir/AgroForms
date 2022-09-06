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
    public function companiesList($hasAllField = false): array
    {
        $result = ArrayHelper::map(Company::find()
                    ->andFilterWhere(['blocked' => false])
                    ->andFilterWhere(['deleted' => false])
                    ->orderBy('id')->asArray()->all(),'id','name');
        if ($hasAllField) {
            $result = ArrayHelper::merge(['' => t('For all companies', 'company')], $result);
        }
        return $result;        
    }
}
