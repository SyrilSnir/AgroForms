<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;
use app\models\Data\Languages;
use Yii;

/**
 * Description of TextBlockForm
 *
 * @author kotov
 */
class TextBlockForm extends BaseParametersForm
{
    public $text;
    public $textEng;
    
    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        
        if ($field) {
            $this->text = $this->paramsArray['text'] ?? ''; 
            $this->textEng = $this->paramsArray['textEng'] ?? ''; 
        }
    } 
    
    public function rules(): array
    {
        return [
                [['text','textEng'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'text' => Yii::t('app','Display text'),
            'textEng' => Yii::t('app','Display text') . ' (ENG)',
        ];
    }

    public function getViewParameters(): array
    {
        $value = (Yii::$app->language == Languages::RUSSIAN) ?
                $this->text :
                $this->textEng;
        $attributes['text'] = [
            'attribute' => 'text',
            'value' => $value
        ]; 
        return $attributes;
    }

}
