<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\helpers\View\Exhibition;

use app\core\helpers\View\StatusHelper;
use app\models\ActiveRecord\Exhibition\Exhibition;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of ExhibitionStatusHelper
 *
 * @author kotov
 */
class ExhibitionStatusHelper extends StatusHelper
{
    public static function statusList() :array
    {
        $statusList = [
            Exhibition::STATUS_COMPLETED => t('Completed','exhibitions'),
            Exhibition::STATUS_ACTIVE => t('Active','exhibitions'),
        ];
        return $statusList;
    }

    public static function getStatusLabel(string $status): string
    {
        switch ($status) {
            case Exhibition::STATUS_ACTIVE:
                $className = 'badge badge-info';
                break;
            case Exhibition::STATUS_COMPLETED:
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
