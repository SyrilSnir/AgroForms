<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;
use Yii;

/**
 * Description of FormField
 *
 * @author kotov
 */
abstract class FillableField extends BaseParametersForm
{
    public $required;   
    
    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        $this->required = $this->paramsArray['required'] ?? false;         
        
    }
    public function rules(): array
    {
        return [
            [['required'], 'boolean'],
        ];
    } 
    
    public function attributeLabels(): array
    {
        return [
            'required' => Yii::t('app','Required field'),            
        ];
    }
    
    public function getViewParameters(): array
    {
        return [
            'required' => [
                'attribute' => 'required',
                'value' => $this->required ? t('Yes'): t('No')        
            ],            
        ];
    }
}
