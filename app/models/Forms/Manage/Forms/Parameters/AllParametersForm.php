<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;
use app\models\Data\SpecialPriceTypes;
use Yii;

/**
 * Description of AllParametersForm
 *
 * @author kotov
 */
class AllParametersForm extends BaseParametersForm
{  
    //put your code here
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
    
    //
    public $digitPrice;
    public $freeDigitCount; 
    /**
     * 
     * @var int
     */
    public $groupType;
    
    public $unitPrice;    
    
    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        $this->isComputed = $this->paramsArray['isComputed'] ?? false;        
        $this->specialPriceType = $this->paramsArray['specialPriceType'] ?? 0;
        $this->required = $this->paramsArray['required'] ?? false; 
        $this->freeDigitCount = $this->paramsArray['freeDigitCount'] ?? 0;
        $this->digitPrice = $this->paramsArray['digitPrice'] ?? 0;  
        $this->groupType = $this->paramsArray['groupType'] ?? self::STANDART_GROUP_TYPE;  
        $this->html = $this->paramsArray['html'] ?? ''; 
        $this->htmlEng = $this->paramsArray['htmlEng'] ?? '';    
        $this->text = $this->paramsArray['text'] ?? ''; 
        $this->textEng = $this->paramsArray['textEng'] ?? '';         
        
    }
    
    public function rules(): array
    {
        return [
                [['required','isComputed','allCategories'], 'boolean'],
                [['text','textEng','htmlEng','html'], 'safe'],
                [['unit','unitPrice','specialPriceType','digitPrice', 'freeDigitCount','groupType'], 'integer'],
                ['categories','each', 'rule' => ['integer']], 
                ['groupType','integer'],
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
            'freeDigitCount' => Yii::t('app','The number of free characters in the frieze inscription'),
            'digitPrice' => Yii::t('app','The cost of the frieze lettering symbol'),
            'groupType' => t('Group type'),
        ];
    }

    public function getViewParameters(): array
    {
        return [];
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
