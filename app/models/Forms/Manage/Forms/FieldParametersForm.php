<?php

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Nomenclature\Unit;
use Yii;
use yii\base\Model;
use function GuzzleHttp\json_decode;

/**
 * Description of FieldParametersForm
 *
 * @property Unit|null $unitModel Description
 * @author kotov
 */
class FieldParametersForm extends Model
{
    const SCENARIO_TEXT_BLOCK = 'text';
    const SCENARIO_HTML_BLOCK = 'html';
    const SCENARIO_NUMBER_INPUT = 'number';


    public $required;
    public $isComputed;


    public $html;
    public $htmlEng;
    public $text;
    public $textEng;
    public $unit;
    
    public $unitPrice;


    public function __construct(Field $field = null,$config = array())
    {
        $parameters = '[]';
        if ($field) {
            $parameters = $field->parameters ?? '';
        }
        $paramsArray = json_decode($parameters,true);    
        $this->required = $paramsArray['required'] ?? false; 
        $this->html = $paramsArray['html'] ?? ''; 
        $this->htmlEng = $paramsArray['htmlEng'] ?? ''; 
        $this->text = $paramsArray['text'] ?? ''; 
        $this->textEng = $paramsArray['textEng'] ?? ''; 
        $this->unit = $paramsArray['unit'] ?? 0;
        $this->unitPrice = $paramsArray['unitPrice'] ?? null;
        $this->isComputed = $paramsArray['isComputed'] ?? false;
        parent::__construct($config);
    }
    
    public function rules(): array
    {
        return [
                [['required','isComputed'], 'boolean'],
                [['text','textEng','htmlEng','html'], 'safe'],
                [['unit','unitPrice'], 'integer']
            ];
    }
    
    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => [
                'required',
                    'text',
                'textEng',
                    'html',
                 'htmlEng',
                    'unit',
                    'unitPrice',
                'isComputed'
            ],
            self::SCENARIO_TEXT_BLOCK => [
                'text',
                'textEng'
            ],
            self::SCENARIO_HTML_BLOCK => [
                'html',
                'htmlEng'
            ],
            
        ];
    }    
    public function attributeLabels(): array
    {
        return [
            'required' => Yii::t('app','Required field'),
            'text' => Yii::t('app','Display text'),
            'textEng' => Yii::t('app','Display text') . ' (ENG)',
            'html' => Yii::t('app','Display text'),
            'htmlEng' => Yii::t('app','Display text') . ' (ENG)',
            'unit' => Yii::t('app','Unit'),
            'unitPrice' => Yii::t('app','Price per one'),
            'isComputed' => Yii::t('app','Calculated field'),
        ];
    }
    
    public function getUnitModel() :?Unit
    {
        return Unit::findOne(['id' => $this->unit]);
    }
}
