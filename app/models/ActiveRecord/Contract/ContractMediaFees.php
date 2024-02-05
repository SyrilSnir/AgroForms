<?php

namespace app\models\ActiveRecord\Contract;

use app\models\Forms\Manage\Contract\ContractMediaFeeForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "contract_media_fees".
 *
 * @property int $id
 * @property int $contract_id Номер договора
 * @property int $media_fee_type Тип взноса
 * @property int $count Количество взносов
 *
 * @property Contracts $contract
 * @property ContractMediaFees[] $contractMediaFees
 * @property MediaFeeTypes $mediaFeeType
 */
class ContractMediaFees extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_media_fees';
    }
    
    public static function create (ContractMediaFeeForm $form): self 
    {
        $model = new self();
        $model->contract_id = $form->contractId;
        $model->media_fee_type = $form->mediaFeeType;
        $model->count = $form->count;
        return $model;
    }
    
    public function edit(ContractMediaFeeForm $form): void 
    {
        $this->media_fee_type = $form->mediaFeeType;
        $this->count = $form->count;        
    }

    /**
     * Gets query for [[Contracts]].
     *
     * @return ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contracts::class, ['id' => 'contract_id']);
    }

    /**
     * Gets query for [[MediaFeeType]].
     *
     * @return ActiveQuery
     */
    public function getMediaFeeType()
    {
        return $this->hasOne(MediaFeeTypes::class, ['id' => 'media_fee_type']);
    }
}
