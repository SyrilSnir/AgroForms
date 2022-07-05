<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\Lists\GetCategoriesListTrait;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Nomenclature\Unit;
use app\models\Data\SpecialPriceTypes;
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

    use GetCategoriesListTrait;    

    public $required;
    public $isComputed;
    /**
     * 
     * @var int
     */
    public $specialPriceType;
    public $allCategories;
    public $html;
    public $htmlEng;
    public $text;
    public $textEng;
    public $unit;
    public $categories;






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
        $this->allCategories = $paramsArray['allCategories'] ?? true;
        $this->categories = $paramsArray['categories'] ?? [];
        $this->specialPriceType = $paramsArray['specialPriceType'] ?? 0;
        parent::__construct($config);
    }
    
    public function rules(): array
    {
        return [
                [['required','isComputed','allCategories'], 'boolean'],
                [['text','textEng','htmlEng','html'], 'safe'],
                [['unit','unitPrice','specialPriceType'], 'integer'],
                ['categories','each', 'rule' => ['integer']], 
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
                'isComputed',
                'allCategories',
                'categories',
                'specialPriceType',
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
            'specialPriceType' => Yii::t('app', 'Calculation for special price rules'),
            'allCategories' => Yii::t('app/equipment', 'All categories'),    
            'categories' => Yii::t('app', 'Categories'),
        ];
    }
    
    public function getUnitModel() :?Unit
    {
        return Unit::findOne(['id' => $this->unit]);
    }
    
    public function getSpecialPriceTypes(): array
    {
        return [
            SpecialPriceTypes::TYPE_VALUTE => t('Fixed price'),
            SpecialPriceTypes::TYPE_PERCENT => t('Percentage of base cost'),
            SpecialPriceTypes::TYPE_COEFFICIENT => t('Markup factor'),
        ];
    }
}
