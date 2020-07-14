<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Geography\City;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetCitiesTrait 
{
    public function citiesList(): array
    {
        $result = [];
        if ($this->regionId) {
            $result = ArrayHelper::map(City::find()->andFilterWhere(['region_id' => $this->regionId])->orderBy('name')->asArray()->all(), 'id', 'name');
        }

        return (count($result) > 0) ? $result : [ 0 => 'Не найдено ни одного города в выбранном регионе'];
        
    }
}
