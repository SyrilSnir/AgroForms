<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;
use yii\helpers\ArrayHelper;

/**
 * Description of AttachmentField
 *
 * @author kotov
 */
class AttachmentField extends ComputedField
{
    
    public $attachment;

    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        if ($field) {
            $this->attachment = $this->paramsArray['attachment'] ?? 0;
        }
    }
    
    public function rules(): array
    {        
        $rules = [
                [['attachment'], 'integer'],            
        ];
        return ArrayHelper::merge($rules, parent::rules());
    }
    //put your code here
    public function getViewParameters(): array
    {
        $attributes['attachment'] = [
            'attribute' => 'attachment',
            'value' => BaseParametersForm::attachmentTypesList()[$this->attachment]
        ];     

        return  ArrayHelper::merge(parent::getViewParameters(), $attributes);       
    }
    
    public function attributeLabels(): array
    {
        $attributeLabels = [
            'attachment' => t('Valid file types'),
        ];
        return ArrayHelper::merge($attributeLabels, parent::attributeLabels()); 
    }    

}
