<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\ActiveRecord;

use app\models\Data\Languages;
use Yii;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait MultilangTrait
{
    protected $multilangEnabled = true;
    
    
    public function __get($name)
    {
        if ($this->isRussian() || $this->multilangEnabled == false) {
            return parent::__get($name);
        }
        $prop_eng = $name . '_eng';
        $propEng = $name . 'Eng';
        if (in_array($prop_eng, $this->allAvailableFields()) && !empty($this->$prop_eng)) {
            return parent::__get($prop_eng);
        }
        if (in_array($propEng, $this->allAvailableFields()) && !empty($this->$propEng)) {
            return parent::__get($propEng);
        }                
        return parent::__get($name);
    }
    
    public function enableMultilang()
    {
        $this->multilangEnabled = true;
    }
    
    public function disableMultilang()
    {
        $this->multilangEnabled = false;
    }
    
    /**
     * Дополнительные поля, которые могут быть переведены но не относящеся к модели ActiveRecord
     * @return array
     */
    public function extraMultilangFields() :array 
    {
        return [];
    }
    
    /**
     * Все возможные переводимые поля
     * @return array
     */
    public function allAvailableFields() : array 
    {
        return ArrayHelper::merge($this->attributes(), $this->extraMultilangFields());
    }
    public function isRussian() :bool
    {
        if (Yii::$app->language == Languages::RUSSIAN) {
            return true;
        }
        return false;
    }
}
