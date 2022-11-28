<?php

namespace app\models\Forms\Manage\Contract;

use app\core\helpers\Utils\DateHelper;
use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetExhibitionsTrait;
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
    public $exhibitionId;
    public $status;

    use GetCompanyNamesTrait, GetExhibitionsTrait;
    
    public function __construct(Contracts $model = null, $config = []) 
    {
        parent::__construct($config);
        if ($model) {
            $this->number = $model->number;
            $this->companyId = $model->company_id;
            $this->date = DateHelper::timestampToDate($model->date);
            $this->status = $model->status;
            $this->exhibitionId = $model->exhibition_id;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['number', 'status', 'date','companyId','exhibitionId'], 'required'],
            [['date'],'date'],
            [['number'], 'string', 'max' => 255]
        ];
    }
    
    public function attributeLabels(): array 
    {
        return [
            'number' => t('Number of contract'),
            'date' => t('Date'),
            'status' => t('Status'),
            'companyId' => t('Company','company'),
            'exhibitionId' => t('Exhibition'),            
        ];
    }
}
