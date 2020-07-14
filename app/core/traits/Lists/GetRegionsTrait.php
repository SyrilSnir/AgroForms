<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Geography\Region;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetRegionsTrait
{
    public function regionsList():array
    {
        $result = ArrayHelper::map(Region::find()
                ->orderBy('name')                
                ->asArray()
                ->andFilterWhere(['country_id' => $this->countryId])
                ->all(), 'id', 'name');

        return (count($result) > 0) ? $result : [ 0 => 'Не найдено ни одного региона в выбранной страны' ];
    }
}
