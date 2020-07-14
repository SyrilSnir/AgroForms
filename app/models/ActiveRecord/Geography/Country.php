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
     * @return \self
     */
    public static function create(string $name):self
    {
        $model = new self();
        $model->name = $name;
        return $model;
    }

    /**
     * 
     * @param string $name
     */
    public function edit(string $name)
    {
        $this->name = $name;
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
