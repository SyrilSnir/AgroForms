<?php

namespace app\models\ActiveRecord\Contract;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\Forms\Manage\Contract\MediaFeeTypeForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "media_fee_types".
 *
 * @property int $id
 * @property string $name Название взноса
 * @property string $name_eng Название взноса (ENG)
 *
 * @property ContractMediaFees[] $contractMediaFees
 */
class MediaFeeTypes extends ActiveRecord
{
    use MultilangTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_fee_types';
    }
    
    public static function create(MediaFeeTypeForm $form): self
    {
        $model = new self();
        $model->name = $form->name;
        $model->name_eng = $form->nameEng;
        return $model;
    }
    
    public function edit(MediaFeeTypeForm $form) :void
    {
        $form->name = $form->name;
        $form->name_eng = $form->nameEng;        
    }

    /**
     * Gets query for [[ContractMediaFees]].
     *
     * @return ActiveQuery
     */
    public function getContractMediaFees()
    {
        return $this->hasMany(ContractMediaFees::class, ['media_fee_type' => 'id']);
    }
}
