<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\core\helpers\View\YesNoStatusHelper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of CheckboxForm
 *
 * @author kotov
 */
class CheckboxForm extends ComputedField
{
    /**
     * 
     * @var bool
     */
    public $hasCommentField;
    
    public function rules(): array
    {
        $rules = [
             [['hasCommentField'], 'boolean'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    } 
    
    public function getViewParameters(): array
    {
        $attributes = [];
        if ($this->hasCommentField) {
            $attributes['hasCommentField'] = [
                'attribute' => 'hasCommentField',
                'format' => 'raw',
                'value' => YesNoStatusHelper::getStatusLabel($this->hasCommentField)
            ];            
        }
        return ArrayHelper::merge(parent::getViewParameters(),$attributes);
    }

    public function attributeLabels(): array
    {        
        $attributeLabels = [
            'hasCommentField' => Yii::t('app','Comment available'),
        ];
        return ArrayHelper::merge($attributeLabels, parent::attributeLabels()); 
    }    
}
