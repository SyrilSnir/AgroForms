<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of ComputedField
 *
 * @author kotov
 */
abstract class ComputedField extends FillableField
{
    public $isComputed;
    
    public $specialPriceType;   
    
    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        $this->isComputed = $this->paramsArray['isComputed'] ?? false;        
        $this->specialPriceType = $this->paramsArray['specialPriceType'] ?? 0;        
    }


    public function rules(): array
    {
        $rules = [
             [['isComputed'], 'boolean'],
            [['specialPriceType'],'integer'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    }
    
    public function attributeLabels(): array
    {
        $attributeLabels = [
            'isComputed' => Yii::t('app','Calculated field'),
        ];
        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }

    public function getViewParameters(): array
    {
        $attributes = [
            'isComputed' => [
                'attribute' => 'isComputed',
                'value' => $this->isComputed ? t('Yes'): t('No')          
            ],            
        ];
        return ArrayHelper::merge($attributes, parent::getViewParameters());
    }    
}
