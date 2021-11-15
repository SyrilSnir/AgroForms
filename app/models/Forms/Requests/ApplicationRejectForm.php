<?php

namespace app\models\Forms\Requests;

use app\models\ActiveRecord\Logs\ApplicationRejectLog;
use yii\base\Model;

/**
 * Description of ApplicationRejectForm
 *
 * @author kotov
 */
class ApplicationRejectForm extends Model
{
    public $comment;
    public $requestId;


    public function __construct(ApplicationRejectLog $model = null, $config = [])
    {
        if ($model) {
            $this->comment = $model->comment;
            $this->requestId = $model->request_id;
        }
        parent::__construct($config);
    }
}
