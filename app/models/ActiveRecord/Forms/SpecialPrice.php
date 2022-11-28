<?php

namespace app\models\ActiveRecord\Forms;

use DateTime;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%special_price}}".
 *
 * @property int $id
 * @property int|null $field_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $startDateTimestamp
 * @property int $endDateTimestamp
 * @property float|null $price
 *
 * @property Field $field
 */
class SpecialPrice extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%special_price}}';
    }
    
    public static function create(int $fieldId,string $startDate, string $endDate, float $price):self
    {
        $model = new self();
        $model->field_id = $fieldId;
        $model->start_date =  DateTime::createFromFormat('d.m.Y', $startDate)->format('Y-m-d');
        $model->end_date =  DateTime::createFromFormat('d.m.Y', $endDate)->format('Y-m-d');
        $model->price = $price;
        return $model;
    }

    public function edit(string $startDate, string $endDate, float $price) 
    {
        $this->start_date =  DateTime::createFromFormat('d.m.Y', $startDate)->format('Y-m-d');
        $this->end_date =  DateTime::createFromFormat('d.m.Y', $endDate)->format('Y-m-d');
        $this->price = $price;        
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id'], 'integer'],
            [['price'], 'number'],
            [['start_date', 'end_date'], 'safe'],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::class, 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Field ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'price' => 'Price',
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
    
    public function getStartDateTimestamp(): int
    {
        return DateTime::createFromFormat('Y-m-d', $this->start_date)->getTimestamp();
    }
    
    public function getEndDateTimestamp(): int
    {
        return DateTime::createFromFormat('Y-m-d', $this->end_date)->getTimestamp();
    }    
    
}
