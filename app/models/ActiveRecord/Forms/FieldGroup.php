<?php

namespace app\models\ActiveRecord\Forms;

use Yii;

/**
 * This is the model class for table "{{%field_groups}}".
 *
 * @property int $id
 * @property string $name Название группы полей
 * @property string|null $description Описание
 * @property string $name_eng Название группы полей (ENG)
 * @property string|null $description_eng Описание (ENG)
 * @property int|null $order Порядок вывода
 * 
 * @property Field[] $fields Description
 */
class FieldGroup extends \yii\db\ActiveRecord
{
    
    const UNDEFINED_FIELD_GROUP = 0;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%field_groups}}';
    }

    /**
     * 
     * @param string $name
     * @param string $description
     * @param string $nameEng
     * @param string $descriptionEng
     * @param int $order
     * @return \self
     */
    public static function create(
            string $name,
            string $description,
            string $nameEng,
            string $descriptionEng,
            int $order = null
            ):self
    {
        $fieldGroup = new self();
        $fieldGroup->name = $name;
        $fieldGroup->name_eng = $nameEng;

        $fieldGroup->description = $description;
        $fieldGroup->description_eng = $descriptionEng;

        $fieldGroup->order = $order;
        
        return $fieldGroup;
    }

    /**
     * 
     * @param string $name
     * @param string $description
     * @param string $nameEng
     * @param string $descriptionEng
     * @param int $order
     * @return \self
     */
     public function edit(
            string $name,
            string $description,
            string $nameEng,
            string $descriptionEng,
            int $order = null
            )
    {
        $this->name = $name;
        $this->name_eng = $nameEng;
        
        $this->description = $description;
        $this->description_eng = $descriptionEng;
        
        $this->order = $order;        
    }   
    
    public function getFields()
    {
        return $this->hasMany(Field::class, ['field_group_id' => 'id' ])->orderBy('order');
    }
}
