<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\core\traits\ActiveRecord;

use app\core\helpers\Utils\DateHelper;
use app\models\Data\Languages;
use Yii;

/**
 * Description of DateMultilangTrait
 *
 * @author kotov
 */
trait DateMultilangTrait
{
    public function translateDateField(string $dateField): string
    {
        if (!in_array($dateField, $this->attributes())) {
            return '';
        }
        if (Yii::$app->language == Languages::RUSSIAN) {
            return DateHelper::timestampToDate($this->$dateField);
        }
        return DateHelper::timestampToDate($this->$dateField,'Y-m-d');
    }
}
