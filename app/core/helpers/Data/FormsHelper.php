<?php

namespace app\core\helpers\Data;

use app\models\ActiveRecord\Forms\Form;
use yii\helpers\ArrayHelper;

/**
 * Description of FormsHelper
 *
 * @author kotov
 */
class FormsHelper
{
    public static function formsList():array
    {
        return array_reduce(
                ArrayHelper::toArray(Form::find()->orderBy('order')->all()),
                function($result,$element){
                    $result[$element['id']] = $element['title'] .': ' . $element['name'];
                    return $result;
        },[]);
    }
}
