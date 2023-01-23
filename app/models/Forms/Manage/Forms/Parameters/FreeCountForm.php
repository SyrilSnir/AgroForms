<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of FreeCountForm
 *
 * @author kotov
 */
class FreeCountForm extends ComputedField
{
    public $freeCount;   
    
    public function rules(): array
    {
        $rules = [
             [['freeCount'], 'integer'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    }    
    
    public function getViewParameters(): array
    {
        $attributes = [
            'freeCount' => [
                'attribute' => 'freeCount',
                'value' => $this->freeCount          
            ],            
        ];
        return ArrayHelper::merge(parent::getViewParameters(),$attributes);
    }
    
    public function attributeLabels(): array
    {        
        $attributeLabels = [
            'freeCount' => Yii::t('app','Number of free'),
        ];
        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());        
    }    
}
