<?php

namespace app\models\ActiveRecord\Companies;

use app\models\ActiveRecord\Geography\City;
use app\models\ActiveRecord\Geography\Country;
use app\models\ActiveRecord\Geography\Region;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *
 * @property int $id
 * @property int|null $index Почтовый индекс
 * @property int $city_id Город
 * @property string $address Улица, дом
 * 
 * @property Country $country Страна
 * @property Region $region Регион
 * @property City $city Город
 * @property Company $company
 */
abstract class Address extends ActiveRecord
{
        
     /**
     * Gets query for [[Company]].
     *
     * @return ActiveQuery
     */
    abstract public function getCompany();
    
    public static function create(
                string $index,
                int $cityId,
                string $adds            
            ):self 
    {
        $address = new static();
        $address->index = $index;
        $address->city_id = $cityId;
        $address->address = $adds;        
        return $address;
    }

    public function edit(
            string $index,
            int $cityId,
            string $address
            )
    {
        $this->index = $index;
        $this->city_id = $cityId;
        $this->address = $address;
    }

    /**
     * 
     * @return City
     */
    public function getCity() 
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
    
    /**
     * 
     * @return Region
     */
    public function getRegion()
    {
        return $this->city->hasOne(Region::class, ['id' => 'region_id']);
    }
    
    /**
     * 
     * @return Country
     */
    public function getCountry()
    {
        return $this->region->hasOne(Country::class, ['id' => 'country_id']);
    }  
}
