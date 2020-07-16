<?php

namespace app\models\ActiveRecord\Forms;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%field_enums}}".
 *
 * @property int $id
 * @property int $field_id Поле
 * @property string $name Название группы аттрибутов
 * @property string $value Значение
 *
 * @property Fields $field
 */
class FieldEnum extends ActiveRecord
{
    const SESSION_IDENTIFIER = 'FIELD_ENUMS';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%field_enums}}';
    }

    public static function create(
            $fieldId,
            $name,
            $value
            ):self
    {
        $model = new self();
        $model->field_id = $fieldId;
        $model->name = $name;
        $model->value = $value;
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'name', 'value'], 'required'],
            [['field_id'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Поле',
            'name' => 'Название группы аттрибутов',
            'value' => 'Значение',
        ];
    }

    /**
     * Gets query for [[Field]].
     *
     * @return ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::class, ['id' => 'field_id']);
    }
}
