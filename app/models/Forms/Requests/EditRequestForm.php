<?php

namespace app\models\Forms\Requests;

use app\core\helpers\View\Request\RequestStatusHelper;
use app\core\traits\Lists\GetContractsTrait;
use app\models\ActiveRecord\Requests\Request;
use yii\base\Model;

/**
 * Description of ChangeStatusForm
 *
 * @author kotov
 */
class EditRequestForm extends Model
{
    public $requestId;
    
    public $status;
    
    public $contractId;

    use GetContractsTrait; 
    
    public function __construct(Request $model, $config = [])
    {
        parent::__construct($config);
        $this->status = $model->status;
        $this->requestId = $model->id;
        $this->contractId = $model->contract_id;
    }
    
    public function rules():array
    {
        $range = array_keys(RequestStatusHelper::statusList());
        return [
          [['status'],'in', 'range' => $range],
          [['contractId'],'integer'],
        ];
    }
    
    public function attributeLabels():array
    {
        return [
          'status' => t('Application status'),
          'contractId' => t('Number of contract')
        ];
    }
}
