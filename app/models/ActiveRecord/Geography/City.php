<?php

namespace app\models\ActiveRecord\Geography;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cities}}".
 *
 * @property int $id
 * @property string $name Название города
 * @property int $region_id Регион
 *
 * @property Region $region
 * @property Country $country
 */
class City extends ActiveRecord
{
    
    const MOSCOW = 4400;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cities}}';
    }
    
    /**
     * 
     * @param string $name
     * @param int $regionId
     * @return \self
     */
    public static function create(
            string $name,
            int $regionId
            ):self
    {
        $model = new self();
        $model->name = $name;
        $model->region_id = $regionId;
        return $model;
    }
    
    /**
     * 
     * @param string $name
     * @param int $regionId
     */
    public function edit(
            string $name,
            int $regionId            
            )
    {
        $this->name = $name;
        $this->region_id = $regionId;
    }


    /**
     * Gets query for [[Region]].
     *
     * @return ActiveQuery
     */
    public function getRegion()
    {

       return $this->hasOne(Region::class, ['id' => 'region_id']);
    }
    
    public function getCountry()
    {
       return $this->region->hasOne(Country::class, ['id' => 'country_id']);
    }
}
