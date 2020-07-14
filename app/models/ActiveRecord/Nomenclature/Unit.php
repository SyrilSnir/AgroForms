<?php

namespace app\models\ActiveRecord\Nomenclature;

use Yii;

/**
 * This is the model class for table "{{%units}}".
 *
 * @property int $id
 * @property string $name Наминование
 * @property string|null $short_name Краткое наименование
 *
 * @property string $name_eng Наминование (eng)
 * @property string|null $short_name_eng Краткое наименование (eng)
 * 
 * @property AdditionalEquipment[] $additionalEquipments
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%units}}';
    }
    
    public static function create(
            string $name,
            string $shortName = null,
            string $nameEng = null,
            string $shortNameEng = null            
            ):self 
    {
        $unit = new static();
        $unit->name = $name;
        $unit->short_name = $shortName;
        $unit->name_eng = $nameEng;
        $unit->short_name_eng = $shortNameEng;
        return $unit;
    }
    
    public function edit(
            string $name,
            string $shortName = null,
            string $nameEng = null,
            string $shortNameEng = null  
            )
    {
        $this->name = $name;
        $this->short_name = $shortName;
        $this->name_eng = $nameEng;
        $this->short_name_eng = $shortNameEng;
    }

    /**
     * Gets query for [[AdditionalEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalEquipments()
    {
        return $this->hasMany(AdditionalEquipment::className(), ['unit_id' => 'id']);
    }
}
