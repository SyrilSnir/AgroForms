<?php

namespace app\models\ActiveRecord\Geography;

use app\core\traits\ActiveRecord\MultilangTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%regions}}".
 *
 * @property int $id
 * @property string $name Название региона
 * @property string $name_eng Название региона (ENG)
 * @property int $country_id Страна
 *
 * @property City[] $cities
 * @property Country $country
 */
class Region extends ActiveRecord
{
    use MultilangTrait;
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
     * @param string $nameEng
     * @return \self
     */
    public static function create(
            string $name,
            int $countryId,
            string $nameEng = ''
            ):self
    {
        $model = new self();
        $model->name = $name;
        $model->name_eng = $nameEng;
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
            int $countryId,
            string $nameEng = ''
            )
    {
        $this->name = $name;
        $this->name_eng = $nameEng;
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
