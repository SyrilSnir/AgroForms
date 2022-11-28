<?php

namespace app\models\Forms\Requests;

use yii\base\Model;
use yii\web\UploadedFile;

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
    
    public $formId;
    
    public $loadedFile;
    
    public $hasFile;
    
    public $contractId;
    
    public $companyId;

    public function rules()
    {
        return [
            [['userId','formId','contractId','companyId'],'required'],            
            [['fields'],'required'],
            [['loadedFile'],'file'],            
            [['hasFile'],'boolean'],            
            [['total','basePrice','userId','formId','contractId','companyId'],'integer'],
            [['draft'],'boolean'],
        ];
    }
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->loadedFile = UploadedFile::getInstance($this,'loadedFile');
            return true;
        }
        return false;
    }    
}
