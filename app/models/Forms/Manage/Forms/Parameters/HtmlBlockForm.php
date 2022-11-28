<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;
use app\models\Data\Languages;
use Yii;

/**
 * Description of HtmlBlockForm
 *
 * @author kotov
 */
class HtmlBlockForm extends BaseParametersForm
{
    public $html;
    public $htmlEng;

    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        
        if ($field) {
            $this->html = $this->paramsArray['html'] ?? ''; 
            $this->htmlEng = $this->paramsArray['htmlEng'] ?? '';
        }
    } 
    
    public function rules(): array
    {
        return [
            [['htmlEng','html'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'html' => Yii::t('app','Display text'),
            'htmlEng' => Yii::t('app','Display text') . ' (ENG)',
        ];
    }

    public function getViewParameters(): array
    {
        $value = (Yii::$app->language == Languages::RUSSIAN) ? 
                $this->html :
                $this->htmlEng;
        $attributes['html'] = [
            'attribute' => 'html',
            'value' => $value,
            'format' => 'raw'

        ];  
        return $attributes;
    }

}
