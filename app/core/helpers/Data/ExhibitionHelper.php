<?php

namespace app\core\helpers\Data;

use app\models\ActiveRecord\Forms\Form;

/**
 * Description of ExhibitionHelper
 *
 * @author kotov
 */
class ExhibitionHelper 
{
    public static function getForms(int $exhibitionId = null)
    {
        $result = Form::find()
                ->andFilterWhere(['exhibition_id' => $exhibitionId])
                ->orderBy('title','title_eng')
                ->asArray()
                ->all();
        return $result;
    }
}
