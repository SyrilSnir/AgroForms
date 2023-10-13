<?php

namespace app\models\ActiveRecord\Forms;

use app\models\Forms\Manage\Forms\FieldLabelForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "field_labels".
 *
 * @property int $id
 * @property string $name Название
 * @property string|null $name_eng Название (ENG)
 * @property string $code Символьный код
 *
 * @property Fields[] $fields
 */
class FieldLabels extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'field_labels';
    }
    
    public static function create(FieldLabelForm $form): self
    {
        $model = new self();
        $model->name = $form->name;
        $model->name_eng = $form->nameEng;
        $model->code = $form->code;
        return $model;
    }
    
    public function edit(FieldLabelForm $form): void
    {
        $this->name = $form->name;
        $this->name_eng = $form->nameEng;
        $this->code = $form->code;        
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name', 'name_eng', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'name_eng' => 'Name Eng',
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[Fields]].
     *
     * @return ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(Fields::class, ['label_id' => 'id']);
    }
}
