<?php

namespace app\core\helpers\Data;

use app\models\ActiveRecord\Geography\Country;

/**
 * Description of CountriesHelper
 *
 * @author kotov
 */
class CountriesHelper
{
    public function countriesList()
    {
        return Country::find()->select(['id','name','name_eng'])->orderBy('id')->asArray()->all();
    }
}
