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
    /**
     * 
     * @var string
     */
    public $commentCaption;
    /**
     * 
     * @var string
     */
    public $commentCaptionEng;     
    
    public function rules(): array
    {
        $rules = [
             [['hasCommentField'], 'boolean'],
             [['commentCaption','commentCaptionEng'],'string']
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
            $attributes['commentCaption'] = [
                'attribute' => 'commentCaption',
                'value' => $this->commentCaption
            ];
            $attributes['commentCaptionEng'] = [
                'attribute' => 'commentCaptionEng',
                'value' => $this->commentCaptionEng
            ];
            
        }
        return ArrayHelper::merge(parent::getViewParameters(),$attributes);
    }

    public function attributeLabels(): array
    {        
        $attributeLabels = [
            'hasCommentField' => Yii::t('app','Comment available'),
            'commentCaption' => Yii::t('app','Title for comment'),
            'commentCaptionEng' => Yii::t('app','Title for comment') . ' (ENG)',            
        ];
        return ArrayHelper::merge($attributeLabels, parent::attributeLabels()); 
    }    
}
