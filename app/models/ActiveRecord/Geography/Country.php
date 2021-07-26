<?php

namespace app\models\ActiveRecord\Geography;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property int $id
 * @property string $name Название страны
 * @property string|null $code Трехбуквенный код страны
 *
 * @property Region[] $regions
 */
class Country extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%countries}}';
    }

    /**
     * 
     * @param string $name
     * @param string $code
     * @return \self
     */
    public static function create(string $name, string $code = ''):self
    {
        $model = new self();
        $model->name = $name;
        $model->code = $code;
        return $model;
    }

    /**
     * 
     * @param string $name
     * @param string $code
     */
    public function edit(string $name,string $code = '')
    {
        $this->name = $name;
        $this->code = $code;
    }   
    
    /**
     * Gets query for [[Regios]].
     *
     * @return ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::class, ['country_id' => 'id']);
    }
}
