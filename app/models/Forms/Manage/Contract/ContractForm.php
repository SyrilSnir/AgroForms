<?php

namespace app\models\Forms\Manage\Contract;

use app\core\helpers\Utils\DateHelper;
use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetExhibitionsTrait;
use app\core\traits\Lists\GetHallsListTrait;
use app\core\traits\Lists\GetStandNumbersListTrait;
use app\models\ActiveRecord\Contract\Contracts;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of ContractForm
 *
 * @author kotov
 */
class ContractForm extends ManageForm
{
    public $number;
    public $date;
    public $companyId;
    public $hall;
    public $standNumber;
    public $square;
    public $exhibitionId;
    public $registrationFee;
    public $status;
    public $isLogo;

    use GetCompanyNamesTrait, 
            GetExhibitionsTrait, 
            GetStandNumbersListTrait, 
            GetHallsListTrait;
    
    public function __construct(Contracts $model = null, $config = []) 
    {
        parent::__construct($config);
        if ($model) {
            $this->number = $model->number;
            $this->companyId = $model->company_id;
            $this->date = DateHelper::timestampToDate($model->date);
            $this->status = $model->status;
            $this->exhibitionId = $model->exhibition_id;
            $this->square = $model->stand_square;
            $this->hall = $model->hall_id;
            $this->standNumber = $model->stand_number_id;
            $this->isLogo = $model->is_logo;  
            $this->registrationFee = $model->registration_fee;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['number', 'status', 'date','companyId','exhibitionId'], 'required'],
            [['companyId', 'standNumber', 'square','hall','registrationFee'], 'integer'],
            [['date'],'date'],
            [['isLogo'],'boolean'],
            [['number'], 'string', 'max' => 255]
        ];
    }
    
    public function attributeLabels(): array 
    {
        return [
            'number' => t('Number of contract'),
            'date' => t('Date'),
            'status' => t('Status'),
            'square' => t('Stand`s square, m2'),
            'standNumber' => t('Stand`s number'),
            'hall' => t('Hall'),
            'companyId' => t('Company','company'),
            'exhibitionId' => t('Exhibition'),   
            'isLogo' => t('Logo available'),
            'registrationFee' => t('Registration fee (number of pieces)'),
        ];
    }
}
