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
    public $attachment;
    
    //
    public $digitPrice;
    public $freeDigitCount; 
    
    /**
     * 
     * @var int
     */
    public $freeCount;
    /**
     * 
     * @var int
     */
    public $metersPerOne;
    
    /**
     * 
     * @var int
     */    
    public $unitPrice;    
    
    /**
     * 
     * @var int
     */
    public $groupType;    
    
    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        $this->isComputed = $this->paramsArray['isComputed'] ?? false;        
        $this->allCategories = $this->paramsArray['allCategories'] ?? true;
        $this->categories = $this->paramsArray['categories'] ?? [];
        $this->specialPriceType = $this->paramsArray['specialPriceType'] ?? 0;
        $this->required = $this->paramsArray['required'] ?? false; 
        $this->freeDigitCount = $this->paramsArray['freeDigitCount'] ?? 0;
        $this->freeCount = $this->paramsArray['freeCount'] ?? 0;
        $this->metersPerOne = $this->paramsArray['metersPerOne'] ?? 0;
        $this->digitPrice = $this->paramsArray['digitPrice'] ?? 0;  
        $this->groupType = $this->paramsArray['groupType'] ?? self::STANDART_GROUP_TYPE;  
        $this->html = $this->paramsArray['html'] ?? ''; 
        $this->htmlEng = $this->paramsArray['htmlEng'] ?? '';    
        $this->text = $this->paramsArray['text'] ?? ''; 
        $this->textEng = $this->paramsArray['textEng'] ?? '';         
        $this->unit = $this->paramsArray['unit'] ?? '';         
        $this->unitPrice = $this->paramsArray['unitPrice'] ?? ''; 
        $this->attachment = $this->paramsArray['attachment'] ?? 0;
        
    }
    
    public function rules(): array
    {
        return [
                [['required','isComputed','allCategories'], 'boolean'],
                [['text','textEng','htmlEng','html'], 'safe'],
                [['unit','unitPrice','specialPriceType','digitPrice', 'freeDigitCount','groupType','attachment','freeCount','metersPerOne'], 'integer'],
                ['categories','each', 'rule' => ['integer']],            
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
            'attachment' => t('Valid file types'),
            'freeCount' => Yii::t('app','Number of free'),   
            'metersPerOne' => Yii::t('app','m2 per badge (free)'),            
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
