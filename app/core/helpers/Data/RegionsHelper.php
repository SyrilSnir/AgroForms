<?php

namespace app\core\helpers\Data;

use app\models\ActiveRecord\Geography\Region;


/**
 * Description of RegionsHelper
 *
 * @author kotov
 */
class RegionsHelper 
{
    public static function getRegionsOfCountry(int $countryId)
    {
        return Region::find()
                ->orderBy('name')
                ->asArray()
                ->andFilterWhere(['country_id' => $countryId])
                ->all();
    }
}
