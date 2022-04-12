<?php

namespace app\models\ActiveRecord\Contract;

use app\models\ActiveRecord\Companies\Company;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%company_contracts}}".
 *
 * @property int $company_id
 * @property int $contracts_id
 *
 * @property Company $company
 * @property Contracts $contracts
 */
class CompanyContracts extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%company_contracts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'contracts_id'], 'required'],
            [['company_id', 'contracts_id'], 'integer'],
            [['company_id', 'contracts_id'], 'unique', 'targetAttribute' => ['company_id', 'contracts_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['contracts_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contracts::className(), 'targetAttribute' => ['contracts_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'contracts_id' => 'Contracts ID',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[Contracts]].
     *
     * @return ActiveQuery
     */
    public function getContracts()
    {
        return $this->hasOne(Contracts::class, ['id' => 'contracts_id']);
    }
}
