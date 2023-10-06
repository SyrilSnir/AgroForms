<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\Lists\GetCategoriesListTrait;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Nomenclature\Unit;
use app\models\Data\SpecialPriceTypes;
use app\models\Forms\Manage\Forms\Parameters\ComputedField;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of FieldParametersForm
 *
 * @property Unit|null $unitModel Description
 * @author kotov
 */
class FieldParametersForm extends ComputedField
{

    use GetCategoriesListTrait;    
    /**
     * 
     * @var int
     */
    public $allCategories;
    public $unit;
    public $categories;


    public function __construct(Field $field = null,$config = array())
    {
        parent::__construct($field, $config);        
 
        $this->unit = $this->paramsArray['unit'] ?? 0;
        $this->unitPrice = $this->paramsArray['unitPrice'] ?? null;
        $this->allCategories = $this->paramsArray['allCategories'] ?? true;
        $this->categories = $this->paramsArray['categories'] ?? [];
    }
    
    public function rules(): array
    {
        $rules =  [
                [['allCategories'], 'boolean'],
                [['unit','unitPrice'], 'integer'],
                ['categories','each', 'rule' => ['integer']], 
            ];
        return ArrayHelper::merge($rules, parent::rules());        
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

    public function getViewParameters(): array
    {
        $attributes = [
        ];
        if ($this->isComputed) { 
            if (in_array($this->field->element_type_id, ElementType::NUMBER_PARAMS)) {
                $attributes['unit'] = [
                    'attribute' => 'unit',
                    'value' => $this->unitModel->name
                ];
            }
            $attributes['unitPrice'] = [
                'attribute' => 'unitPrice',
                'value' => $this->unitPrice
            ];
        }
        return ArrayHelper::merge($attributes, parent::getViewParameters());
    }
    
    public function attributeLabels(): array
    {
        $attributeLabels = [
            'unit' => Yii::t('app','Unit'),
            'unitPrice' => Yii::t('app','Price per one'),
            'allCategories' => Yii::t('app/equipment', 'All categories'),    
            'categories' => Yii::t('app', 'Categories'),
            'freeDigitCount' => Yii::t('app','The number of free characters in the frieze inscription'),
            'digitPrice' => Yii::t('app','The cost of the frieze lettering symbol')
        ];
        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }
}
