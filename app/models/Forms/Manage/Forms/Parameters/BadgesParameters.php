<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of BadgesParameters
 *
 * @author kotov
 */
class BadgesParameters extends ComputedField
{   
    public $metersPerOne;
    //put your code here
    
    public function rules(): array
    {
        $rules = [
             [['metersPerOne'], 'integer'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    } 
    
    public function getViewParameters(): array
    {
        $attributes = [
            'metersPerOne' => [
                'attribute' => 'metersPerOne',
                'value' => $this->metersPerOne          
            ],            
        ];
        return ArrayHelper::merge(parent::getViewParameters(),$attributes);
    }

    public function attributeLabels(): array
    {        
        $attributeLabels = [
            'metersPerOne' => Yii::t('app','m2 per badge (free)'),
        ];
        return ArrayHelper::merge($attributeLabels, parent::attributeLabels()); 
    }   
}
