<?php

namespace app\models\ActiveRecord\Forms;

use app\core\traits\ActiveRecord\MultilangTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%field_enums}}".
 *
 * @property int $id
 * @property int $field_id Поле
 * @property string $name Название группы аттрибутов
 * @property string $name_eng Название группы аттрибутов
 * @property string $value Значение
 * @property int $order Порядковый номер
 *
 * @property Fields $field
 */
class FieldEnum extends ActiveRecord
{
    use MultilangTrait;
    
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
            $value,
            $nameEng = ''
            ):self
    {
        $model = new self();
        $model->field_id = $fieldId;
        $model->name = $name;
        $model->value = $value;
        $model->name_eng = $nameEng;
        return $model;
    }
    
    public function rules()
    {
        return [
            [['name','name_eng','value'], 'safe']
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => t('Field'),
            'name' => t('Item name'),
            'name_eng' => t('Item name') . ' (ENG)',
            'value' => t('Value'),
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
