<?php

namespace app\models\ActiveRecord\Nomenclature;

use app\core\traits\ActiveRecord\MultilangTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%additional_equipment}}".
 *
 * @property int $id
 * @property int|null $group_id Группа оборудования
 * @property string|null $code Код
 * @property string $name Наименование
 * @property string|null $description Описание
 * @property string|null $name_eng Наименование (eng)
 * @property string|null $description_eng Описание (eng)
 * @property int $unit_id Единица измерения
 * @property int $price Стоимость
 *
 * @property Unit $unit
 * @property EquipmentGroup $equipmentGroup
 */
class Equipment extends ActiveRecord
{
    use MultilangTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%additional_equipment}}';
    }

    /**
     * 
     * @param string $name
     * @param int $groupId
     * @param int $unitId
     * @param int $price
     * @param string $description
     * @param string $code
     * @param string $name_eng
     * @param string $description_eng
     * @return \self
     */
    public static function create(
            string $name,
            int $groupId,
            int $unitId,
            int $price,
            string $description = null,
            string $code = null,
            string $nameEng,
            string $descriptionEng
            ):self 
    {
        $equipment = new static();
        $equipment->name = $name;
        $equipment->group_id = $groupId;
        $equipment->unit_id = $unitId;
        $equipment->price = $price;
        $equipment->code = $code;       
        $equipment->description = $description;
        $equipment->name_eng = $nameEng;
        $equipment->description_eng = $descriptionEng;
        return $equipment;
    }
    
    /**
     * 
     * @param string $name
     * @param int $groupId
     * @param int $unitId
     * @param int $price
     * @param string $description
     * @param string $code
     */
    public function edit(
            string $name,
            int $groupId,
            int $unitId,
            int $price,
            string $description = null,
            string $code = null,
            string $nameEng = null,
            string $descriptionEng = null
            )
    {
        $this->name = $name;
        $this->group_id = $groupId;
        $this->unit_id = $unitId;
        $this->price = $price;
        $this->code = $code;       
        $this->description = $description;
        $this->name_eng = $nameEng;
        $this->description_eng = $descriptionEng;
    }    
    
    /**
     * Gets query for [[Unit]].
     *
     * @return ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
    
    public function getEquipmentGroup()
    {
        return $this->hasOne(EquipmentGroup::class, ['id' => 'group_id']);
    }
}
