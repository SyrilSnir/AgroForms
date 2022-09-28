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
    public static function getForms(int $exhibitionId = null,bool $markDeleted = false)
    {
        $result = Form::find()
                ->andFilterWhere(['exhibition_id' => $exhibitionId])
                ->orderBy('title','title_eng')
                ->asArray()
                ->all();
        if ($markDeleted) {
            $result = array_map(function($el) {
                if ($el['deleted'] > 0) {
                    $el['name'] .= ' (удалена)';
                }
                return $el;
            }, $result);
            
        }
        return $result;
    }
}
