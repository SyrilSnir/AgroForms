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
    /**
     * Список доступных форм
     * @param int $exhibitionId ID выставки
     * @return array
     */
    public static function formsList(int $exhibitionId = null):array
    {
        $formsList = ArrayHelper::toArray(Form::find()
              //  ->andFilterWhere(['!=','status', Form::STATUS_DRAFT])
                ->andFilterWhere(['!=','forms.status', Form::STATUS_DRAFT])
                ->andFilterWhere(['exhibition_id'=> $exhibitionId])
                ->orderBy('order')->all());
        
        return array_reduce(
                $formsList,
                function($result,$element){
                    $result[$element['id']] = $element['title'] .': ' . $element['name'];
                    return $result;
        },[]);
    }
}
