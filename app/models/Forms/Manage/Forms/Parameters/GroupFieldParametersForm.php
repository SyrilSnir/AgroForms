<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;

/**
 * Description of GroupFieldParametersForm
 *
 * @author kotov
 */
class GroupFieldParametersForm extends BaseParametersForm
{
    /**
     * 
     * @var int
     */
    public $groupType;        
    
    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        
        if ($field) {
            $this->groupType = $this->paramsArray['groupType'] ?? self::STANDART_GROUP_TYPE;
        }
    }

    public function rules(): array
    {
        return [
                ['groupType','integer'], 
            ];
    }    
    
    public function getViewParameters(): array
    {
        $attributes = [
            [
                'attribute' => 'groupType',
                'value' => $this->groupTypesList()[$this->groupType]
            ]
        ];
        return $attributes;
    }
    
    public function attributeLabels(): array
    {
        return [
            'groupType' => t('Group type')
        ];
    }
    
    

}
