<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\helpers\View\Form;

use app\models\ActiveRecord\Forms\Form;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of FormStatusHelper
 *
 * @author kotov
 */
class FormStatusHelper    {
    
    public static function statusList() :array
    {
        $statusList = [
            Form::STATUS_DRAFT => t('Draft','exhibitions'),
            Form::STATUS_ACTIVE => t('Active','exhibitions'),
            Form::STATUS_ARCHIVE => t('Archive','exhibitions')
        ];
        return $statusList;
    }

    public static function getStatusLabel(string $status): string
    {
        switch ($status) {
            case Form::STATUS_ACTIVE:
                $className = 'badge badge-info';
                break;
            case Form::STATUS_DRAFT:
                $className = 'badge badge-success';
                break;            
            default:
                $className = 'badge badge-warning';
                break;
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $className,
        ]); 
    }
}
