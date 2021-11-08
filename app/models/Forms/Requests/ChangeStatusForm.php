<?php

namespace app\models\Forms\Requests;

use app\core\helpers\View\Request\RequestStatusHelper;
use yii\base\Model;

/**
 * Description of ChangeStatusForm
 *
 * @author kotov
 */
class ChangeStatusForm extends Model
{
    public $requestId;
    
    public $status;

    public function __construct(int $requestId, int $status)
    {
        $this->status = $status;
        $this->requestId = $requestId;
    }
    
    public function rules():array
    {
        $range = array_keys(RequestStatusHelper::statusList());
        return [
          [['status'],'in', 'range' => $range],
        ];
    }
    
    public function attributeLabels():array
    {
        return [
          'status' => 'Статус заявки'
        ];
    }
}
