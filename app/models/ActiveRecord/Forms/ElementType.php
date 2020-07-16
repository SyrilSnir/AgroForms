<?php

namespace app\models\ActiveRecord\Forms;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%element_type}}".
 *
 * @property int $id
 * @property string $name Название элемента фрормы
 * @property string|null $description Описание элемента фрормы
 */
class ElementType extends ActiveRecord
{
    
    const ELEMENT_CHECKBOX = 1;
    const ELEMENT_SELECT = 2;
    const ELEMENT_SELECT_MULTIPLE = 3;
    const ELEMENT_DATE = 4;
    const ELEMENT_DATE_MULTIPLE = 5;
    const ELEMENT_RADIO_BUTTON = 6;
    const ELEMENT_NUMBER_INPUT = 7;
    const ELEMENT_CHECK_NUMBER_INPUT = 8;
    const ELEMENT_TEXT_INPUT = 9;    
    const ELEMENT_FILE = 10;  
    const ELEMENT_FILE_MULTIPLE = 11;  
    const ELEMENT_INFORMATION_IMPORTANT = 12;  
    const ELEMENT_INFORMATION = 13;  
    const ELEMENT_HEADER = 14;
    
    const HAS_ENUM_ATTRIBUTES = [
        self::ELEMENT_SELECT,
        self::ELEMENT_SELECT_MULTIPLE,
        self::ELEMENT_RADIO_BUTTON
    ];
    
    const HTML_BLOCKS = [
        self::ELEMENT_INFORMATION,
        self::ELEMENT_INFORMATION_IMPORTANT
    ];
    
    const TEXT_BLOCKS = [
        self::ELEMENT_HEADER
    ];
    
    const HAS_REQUIRED = [
        self::ELEMENT_NUMBER_INPUT,
        self::ELEMENT_TEXT_INPUT
    ];
    
    const NUMBER_PARAMS = [
        self::ELEMENT_NUMBER_INPUT,
        self::ELEMENT_CHECK_NUMBER_INPUT
    ];
    
    const COMPUTED_FIELDS = [
        self::ELEMENT_CHECKBOX,
        self::ELEMENT_CHECK_NUMBER_INPUT,
        self::ELEMENT_NUMBER_INPUT,
        self::ELEMENT_SELECT,
        self::ELEMENT_SELECT_MULTIPLE,
        self::ELEMENT_RADIO_BUTTON            
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%element_type}}';
    }
    
    public static function create(
            string $name,
            string $description = ''
            ):self
    {
        $attributeGroup = new self();
        $attributeGroup->name = $name;
        $attributeGroup->description = $description;
        return $attributeGroup;
    }
    
    public function edit(
            string $name,
            string $description = ''
            )
    {
        $this->name = $name;
        $this->description = $description;
    }    
}
