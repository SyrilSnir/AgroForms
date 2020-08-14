<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\ActiveRecord;

use app\models\Data\Languages;
use Yii;

/**
 *
 * @author kotov
 */
trait MultilangTrait
{

    public function __get($name)
    {
        if (Yii::$app->language == Languages::RUSSIAN) {
            return parent::__get($name);
        }
        $propEng = $name . '_eng';
        if (!in_array($propEng, $this->attributes()) || empty($this->$propEng)) {
            return parent::__get($name);
        }
        
        return parent::__get($propEng);
    }

}
