<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Lists;

use Yii;

/**
 *
 * @author kotov
 */
trait GetGenderListTrait
{
    public function getGenderData() :array
    {
        return [
            0 => Yii::t('app','Undefined'),
            1 => Yii::t('app','Male'),
            2 => Yii::t('app','Female')
        ];
    }
}
