<?php

namespace app\models\ActiveRecord\Geography;

use app\core\traits\ActiveRecord\MultilangTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cities}}".
 *
 * @property int $id
 * @property string $name Название города
 * @property string $name_eng Название города (ENG)
 * @property int $region_id Регион
 *
 * @property Region $region
 * @property Country $country
 */
class City extends ActiveRecord
{
    use MultilangTrait;
    
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
     * @param string $nameEng
     * @return \self
     */
    public static function create(
            string $name,
            int $regionId,
            string $nameEng = ''
            ):self
    {
        $model = new self();
        $model->name = $name;
        $model->name_eng = $nameEng;
        $model->region_id = $regionId;
        return $model;
    }
    
    /**
     * 
     * @param string $name
     * @param int $regionId
     * @param string $nameEng
     */
    public function edit(
            string $name,
            int $regionId,
            string $nameEng
            )
    {
        $this->name = $name;
        $this->name_eng = $nameEng;
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
