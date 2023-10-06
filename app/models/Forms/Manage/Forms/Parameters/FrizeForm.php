<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\models\ActiveRecord\Forms\Field;
use Yii;

/**
 * Description of FrizeForm
 *
 * @author kotov
 */
class FrizeForm extends BaseParametersForm
{
    public $digitPrice;
    public $freeDigitCount;
    public $friezeFieldType;    
    
    public function __construct(Field $field = null, $config = [])
    {
        parent::__construct($field, $config);
        
        if ($field) {
            $this->freeDigitCount = $this->paramsArray['freeDigitCount'] ?? 0;
            $this->digitPrice = $this->paramsArray['digitPrice'] ?? 0;
        }
    }
    
    public function rules(): array
    {
        return [
            [['digitPrice', 'freeDigitCount','friezeFieldType'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'freeDigitCount' => Yii::t('app','The number of free characters in the frieze inscription'),
            'digitPrice' => Yii::t('app','The cost of the frieze lettering symbol'),
            'friezeFieldType' => Yii::t('app','Input field type'),            
        ];
    }

    public function getViewParameters(): array
    {
        $attributes['freeDigitCount'] = [
            'attribute' => 'freeDigitCount',
            'value' => $this->freeDigitCount
        ];   


        $attributes['digitPrice'] = [
            'attribute' => 'digitPrice',
            'value' => $this->digitPrice
        ];   
        
        $attributes['friezeFieldType'] = [
            'attribute' => 'digitPrice',
            'value' => $this->friezeFieldTypesList()[$this->friezeFieldType]
        ];        

        return $attributes;        
    }

}
