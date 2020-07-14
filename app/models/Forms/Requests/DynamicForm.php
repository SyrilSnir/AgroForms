<?php

namespace app\models\Forms\Requests;

use yii\base\Model;

/**
 * Description of DynamicForm
 *
 * @author kotov
 */
class DynamicForm extends Model
{
    public $fields;
    
    public $total;
    
    public $basePrice;

    public $draft;
    
    public $userId;
    
    public $formType;
    
    public $formId;

    public function rules()
    {
        return [
            [['userId','formId','formType'],'required'],            
            [['fields'],'required'],
            [['total','basePrice','userId','formId','formType'],'integer'],
            [['draft'],'boolean'],
        ];
    }
}
