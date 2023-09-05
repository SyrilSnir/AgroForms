<?php

namespace app\models\ActiveRecord\Contract;

use app\core\traits\ActiveRecord\DateMultilangTrait;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Contract\Query\ContractsQuery;
use app\models\ActiveRecord\Exhibition\Exhibition;
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
 * @property int $exhibition_id Выставка
 * @property int $date Дата заключения договора
 * @property int $stand_number_id Номер стенда
 * @property int $hall_id Зал
 * @property int $stand_square Площадь стенда
 * @property int $status Статус договора
 * @property int $is_logo Доступна загрузка логотипа
 *
 * @property Company $company
 * @property Exhibition $exhibition
 * @property StandNumber $standNumber
 * @property Hall $hall
 */
class Contracts extends ActiveRecord
{
    const STATUS_COMPLETED = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_DECLINED = 0;
    
    use DateMultilangTrait;
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
        $contract->exhibition_id = $form->exhibitionId;
        $contract->stand_number_id = $form->standNumber;
        $contract->hall_id = $form->hall;
        $contract->stand_square = $form->square;
        $contract->status = $form->status;
        $contract->is_logo = $form->isLogo;
        $contract->date =  DateTime::createFromFormat('d.m.Y', $form->date)->getTimestamp();
        return $contract;
    }
    
    public static function createDummy(): self
    {
        $contract = new self();
        $contract->number = '0000';
        return $contract;
    //    $contract->exhibition_id = $exhibitionId;
        
    }

    /**
     * 
     * @return ContractsQuery
     */
    public static function find() 
    {
        return new ContractsQuery(static::class);
    }
    
    public function edit(ContractForm $form): void
    {
        $this->number = $form->number;
        $this->company_id = $form->companyId;
        $this->exhibition_id = $form->exhibitionId;
        $this->stand_number_id = $form->standNumber;
        $this->hall_id = $form->hall;
        $this->stand_square = $form->square;        
        $this->status = $form->status;
        $this->is_logo = $form->isLogo;
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
    

    /**
     * Gets query for [[Exhibition]].
     *
     * @return ActiveQuery
     */
    public function getExhibition()
    {
        return $this->hasOne(Exhibition::class, ['id' => 'exhibition_id']);
    }
        
    public function getStandNumber()
    {
        return $this->hasOne(StandNumber::class, ['id' => 'stand_number_id']);        
    }
    
    public function getHall()
    {
        return $this->hasOne(Hall::class, ['id' => 'hall_id']);  
    }
}
