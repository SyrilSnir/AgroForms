<?php

namespace app\core\helpers\Data;

use app\models\ActiveRecord\Geography\City;


/**
 * Description of CitiesHelper
 *
 * @author kotov
 */
class CitiesHelper
{
    public static function getCitiesOfRegion(int $regionId)
    {
        return City::find()
                ->orderBy('name')
                ->asArray()
                ->andFilterWhere(['region_id' => $regionId])
                ->all();
    }
}
