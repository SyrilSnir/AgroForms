<?php

namespace app\models\ActiveRecord\Geography;

use app\core\traits\ActiveRecord\MultilangTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property int $id
 * @property string $name Название страны
 * @property string $name_eng Название страны (ENG)
 * @property string|null $code Трехбуквенный код страны
 *
 * @property Region[] $regions
 */
class Country extends ActiveRecord
{
    use MultilangTrait;
    
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
     * @param string $nameEng
     * @return \self
     */
    public static function create(string $name, string $code = '', string $nameEng = ''):self
    {
        $model = new self();
        $model->name = $name;
        $model->name_eng = $nameEng;
        $model->code = $code;
        return $model;
    }

    /**
     * 
     * @param string $name
     * @param string $code
     * @param string $nameEng
     */
    public function edit(string $name,string $code = '', $nameEng = '')
    {
        $this->name = $name;
        $this->name_eng = $nameEng;
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
