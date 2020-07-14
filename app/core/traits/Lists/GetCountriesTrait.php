<?php


namespace app\core\traits\Lists;

use app\models\ActiveRecord\Geography\Country;
use yii\helpers\ArrayHelper;
/**
 *
 * @author kotov
 */
trait GetCountriesTrait 
{
    public function countriesList()
    {
        return ArrayHelper::map(Country::find()->orderBy('id')->asArray()->all(), 'id', 'name');
    }
}

