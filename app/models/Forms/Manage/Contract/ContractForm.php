<?php

namespace app\models\Forms\Manage\Contract;

use app\core\helpers\Utils\DateHelper;
use app\core\traits\Lists\GetCompanyNamesTrait;
use app\models\ActiveRecord\Contract\Contracts;
use yii\base\Model;

/**
 * Description of ContractForm
 *
 * @author kotov
 */
class ContractForm extends Model
{
    public $number;
    public $date;
    public $companyId;
    public $status;

    use GetCompanyNamesTrait;
    
    public function __construct(Contracts $model = null, $config = []) 
    {
        parent::__construct($config);
        if ($model) {
            $this->number = $model->number;
            $this->companyId = $model->company_id;
            $this->date = DateHelper::timestampToDate($model->date);
            $this->status = $model->status;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
            [['number', 'status', 'date','companyId'], 'required'],
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
            'companyId' => t('Company','company')
            
        ];
    }
}
