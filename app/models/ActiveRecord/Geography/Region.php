<?php

namespace app\models\ActiveRecord\Geography;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%regions}}".
 *
 * @property int $id
 * @property string $name Название региона
 * @property int $country_id Страна
 *
 * @property City[] $cities
 * @property Country $country
 */
class Region extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%regions}}';
    }
    
    /*
     * @param string $name
     * @param int $countryId
     * @return \self
     */
    public static function create(
            string $name,
            int $countryId
            ):self
    {
        $model = new self();
        $model->name = $name;
        $model->country_id = $countryId;
        return $model;
    }
    
    /**
     * 
     * @param string $name
     * @param int $countryId
     */
    public function edit(
            string $name,
            int $countryId            
            )
    {
        $this->name = $name;
        $this->country_id = $countryId;
    }
    
    /**
     * Gets query for [[Cities]].
     *
     * @return ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['region_id' => 'id']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
}
