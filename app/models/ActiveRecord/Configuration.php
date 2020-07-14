<?php

namespace app\models\ActiveRecord;

use Yii;

/**
 * This is the model class for table "{{%configuration}}".
 *
 * @property int $id
 * @property string $section Раздел
 * @property string $name Название настройки
 * @property string $value Значение
 */
class Configuration extends \yii\db\ActiveRecord
{
    const STAND_SETTINGS_SECTION = 'stand';
    const SMTP_SETTINGS_SECTION = 'mail';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%configuration}}';
    }
    
    /**
     * 
     * @param string $section
     * @param string $name
     * @param string $value
     * @return \self
     */
    public static function create(
            string $section,
            string $name,
            string $value
            ):self
    {
        $model = new self();
        $model->section = $section;
        $model->name = $name;
        $model->value = $value;
        return $model;
    }
    
    /**
     * 
     * @param string $section
     * @param string $name
     * @param string $value
     */    
    public function edit(
            string $section,
            string $name,
            string $value            
            )
    {
        $this->section = $section;
        $this->name = $name;
        $this->value = $value;       
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section', 'name', 'value'], 'required'],
            [['section', 'name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section' => 'Раздел',
            'name' => 'Название настройки',
            'value' => 'Значение',
        ];
    }
}
