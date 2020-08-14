<?php

namespace app\models\ActiveRecord\Nomenclature;

use app\core\traits\ActiveRecord\MultilangTrait;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%equipment_groups}}".
 *
 * @property int $id
 * @property string $name Категория
 * @property string|null $description Описание
 * @property string|null $name_eng Наименование (eng)
 * @property string|null $description_eng Описание (eng)
 */
class EquipmentGroup extends ActiveRecord
{
    use MultilangTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%equipment_groups}}';
    }

/**
 * 
 * @param string $name
 * @param string $description
 * @param string $nameEng
 * @param string $descriptionEng
 * @return \self
 */
    public static function create(
            string $name,
            string $description = null,
            string $nameEng = null,
            string $descriptionEng = null
            
            ):self 
    {
        $equipmentGroup = new static();
        $equipmentGroup->name = $name;
        $equipmentGroup->description = $description;
        $equipmentGroup->name_eng = $nameEng;
        $equipmentGroup->description_eng = $descriptionEng;
        return $equipmentGroup;
    }
    /**
     * 
     * @param string $name
     * @param string $description
     * @param string $nameEng
     * @param string $descriptionEng
     */
    public function edit(
            string $name,
            string $description = null,
            string $nameEng = null,
            string $descriptionEng = null
            )
    {
        $this->name = $name;
        $this->description = $description;
        $this->name_eng = $nameEng;
        $this->description_eng = $descriptionEng;
    }
}
