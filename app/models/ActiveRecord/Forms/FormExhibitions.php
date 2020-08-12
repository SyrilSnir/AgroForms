<?php

namespace app\models\ActiveRecord\Forms;

use app\models\ActiveRecord\Exhibition\Exhibition;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%forms_exhibitions}}".
 *
 * @property int $forms_id
 * @property int $exhibitions_id
 *
 * @property Exhibition $exhibitions
 * @property Form $forms
 */
class FormExhibitions extends ActiveRecord
{
    
    /**
     * 
     * @param int $formId
     * @param int $exhibitionId
     * @return \self
     */
    public static function create(
            int $formId,
            int $exhibitionId
            ):self
    {
        $model = new self();
        $model->forms_id = $formId;
        $model->exhibitions_id = $exhibitionId;
        return $model;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%forms_exhibitions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forms_id', 'exhibitions_id'], 'required'],
            [['forms_id', 'exhibitions_id'], 'integer'],
            [['forms_id', 'exhibitions_id'], 'unique', 'targetAttribute' => ['forms_id', 'exhibitions_id']],
            [['exhibitions_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::className(), 'targetAttribute' => ['exhibitions_id' => 'id']],
            [['forms_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['forms_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'forms_id' => 'Forms ID',
            'exhibitions_id' => 'Exhibitions ID',
        ];
    }

    /**
     * Gets query for [[Exhibition]].
     *
     * @return ActiveQuery
     */
    public function getExhibitions()
    {
        return $this->hasOne(Exhibition::className(), ['id' => 'exhibitions_id']);
    }

    /**
     * Gets query for [[Form]].
     *
     * @return ActiveQuery
     */
    public function getForms()
    {
        return $this->hasOne(Form::className(), ['id' => 'forms_id']);
    }
}
