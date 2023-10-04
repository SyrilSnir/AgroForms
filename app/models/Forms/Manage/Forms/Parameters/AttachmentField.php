<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;

/**
 * Description of AttachmentField
 *
 * @author kotov
 */
class AttachmentField extends BaseParametersForm
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
        return [
                [['attachment'], 'integer'],            
        ];
    }
    //put your code here
    public function getViewParameters(): array
    {
        $attributes['attachment'] = [
            'attribute' => 'attachment',
            'value' => BaseParametersForm::attachmentTypesList()[$this->attachment]
        ];     

        return $attributes;        
    }
    
    public function attributeLabels(): array
    {
        return [
            'attachment' => t('Valid file types'),
        ];
    }    

}
