<?php

namespace app\models\ActiveRecord\Forms;

use Yii;

/**
 * This is the model class for table "{{%field_types}}".
 *
 * @property int $id
 * @property string|null $name Название
 * @property string|null $description Описание
 */
class FieldType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%field_types}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }
}
