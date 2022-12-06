<?php

namespace app\models\Forms\Requests;

use yii\base\Model;

/**
 * Description of RemoveAttachmentForm
 *
 * @author kotov
 */
class RemoveAttachmentForm extends Model
{
    public $requestId;
    
    public $fieldId;
    
    public function rules()
    {   
        return [
            [['requestId','fieldId'],'required'],
            [['requestId','fieldId'],'integer'],
        ];
    }
}
