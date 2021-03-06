<?php

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\Field;
use yii\base\Model;
use function GuzzleHttp\json_decode;

/**
 * Description of FieldParametersForm
 *
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
            'required' => 'Обязательное поле',
            'text' => 'Отображаемый текст',
            'textEng' => 'Отображаемый текст (ENG)',
            'html' => 'Отображаемый текст',
            'htmlEng' => 'Отображаемый текст (ENG)',
            'unit' => 'Единица измерения',
            'unitPrice' => 'Цена за ед.',
            'isComputed' => 'Вычисляемое поле',
        ];
    }
}
