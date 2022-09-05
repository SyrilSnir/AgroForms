<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Exhibition\Exhibition;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetExhibitionsTrait
{
    public function getExhibitionsList($hasAllField = false)
    {
        $result = ArrayHelper::map(Exhibition::find()
                ->orderBy('id')->asArray()->all(), 'id', 'title');
        if ($hasAllField) {
            $result = ArrayHelper::merge(['' => 'Все выставки'], $result);
        }
        return $result;
    }
    
}
