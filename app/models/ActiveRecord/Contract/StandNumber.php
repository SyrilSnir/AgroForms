<?php

namespace app\models\ActiveRecord\Contract;

use app\models\Forms\Manage\Contract\StandNumberForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "stand_number".
 *
 * @property int $id
 * @property string $number Номер
 *
 * @property Contracts[] $contracts
 */
class StandNumber extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stand_number';
    }

    public static function create(StandNumberForm $form):self     
    {
        $model = new self();
        $model->number = $form->number;
        return $model;
    }
    
    public static function createByNumber(string $number): self
    {
        $model = new self();
        $model->number = $number;
        return $model;
    }    

    public function edit(StandNumberForm $form): void
    {
        $this->number = $form->number;
    }
    
    /**
     * Gets query for [[Contracts]].
     *
     * @return ActiveQuery
     */
    public function getContracts()
    {
        return $this->hasMany(Contracts::class, ['stand_number_id' => 'id']);
    }
}
