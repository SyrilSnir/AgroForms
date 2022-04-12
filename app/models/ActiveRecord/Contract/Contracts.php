<?php

namespace app\models\ActiveRecord\Contract;

use app\models\ActiveRecord\Companies\Company;
use app\models\Forms\Manage\Contract\ContractForm;
use DateTime;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%contracts}}".
 *
 * @property int $id
 * @property string $number Номер договора
 * @property int $company_id Компания
 * @property int $date Дата заключения договора
 * @property int $status Статус договора
 *
 * @property Company $company
 */
class Contracts extends ActiveRecord
{
    const STATUS_COMPLETED = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_DECLINED = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contracts}}';
    }
    
    public static function create(ContractForm $form) :self
    {
        $contract = new self();
        $contract->number = $form->number;
        $contract->company_id = $form->companyId;
        $contract->status = $form->status;
        $contract->date =  DateTime::createFromFormat('d.m.Y', $form->date)->getTimestamp();
        return $contract;
    }
    
    public function edit(ContractForm $form): void
    {
        $this->number = $form->number;
        $this->company_id = $form->companyId;
        $this->status = $form->status;
        $this->date =  DateTime::createFromFormat('d.m.Y', $form->date)->getTimestamp();
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
}
