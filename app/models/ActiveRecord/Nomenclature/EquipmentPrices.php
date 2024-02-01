<?php

namespace app\models\ActiveRecord\Nomenclature;

use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\Forms\Nomenclature\EquipmentPricesForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "equipment_prices".
 *
 * @property int $exhibition_id
 * @property int $equipment_id
 * @property int $price Стоимость
 * @property bool $deleted Флаг удаления
 *
 * @property Equipment $equipment
 * @property Exhibition $exhibition
 */
class EquipmentPrices extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_prices';
    }
    
    /**
     * 
     * @param int $exhibitionId
     * @param int $equipmentId
     * @param int $price
     * @return self
     */
    public static function create(int $exhibitionId, int $equipmentId, int $price) :self
    {
        $model = new self();
        $model->equipment_id = $equipmentId;
        $model->exhibition_id = $exhibitionId;
        $model->price = $price;
        return $model;
    }
    
    public function edit(EquipmentPricesForm $form): void
    {
        $this->equipment_id = $form->equipmentId;
        $this->exhibition_id = $form->exhibitionId;
        $this->price = $form->price;        
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exhibition_id', 'equipment_id', 'price'], 'required'],
            [['exhibition_id', 'equipment_id', 'price'], 'integer'],
            [['exhibition_id', 'equipment_id'], 'unique', 'targetAttribute' => ['exhibition_id', 'equipment_id']],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
            [['exhibition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::class, 'targetAttribute' => ['exhibition_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'exhibition_id' => 'Exhibition ID',
            'equipment_id' => 'Equipment ID',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return ActiveQuery
     */
    public function getEquipment()
    {
        return $this->hasOne(Equipment::class, ['id' => 'equipment_id']);
    }

    /**
     * Gets query for [[Exhibition]].
     *
     * @return ActiveQuery
     */
    public function getExhibition()
    {
        return $this->hasOne(Exhibition::class, ['id' => 'exhibition_id']);
    }
}
