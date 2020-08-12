<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Common\Valute;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetValutesListTrait
{
    public function getValutesList()
    {
        return ArrayHelper::map(Valute::find()->orderBy('id')->asArray()->all(), 'id', 'name');
    }
}
