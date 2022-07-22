<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\helpers\View\Form\Modificators\CoefficientModificator;
use app\core\helpers\View\Form\Modificators\PercentModificator;
use app\core\helpers\View\Form\Modificators\PriceModificator;
use app\core\helpers\View\Form\Modificators\StaticModificator;
use app\core\helpers\View\Form\PriceModifyInterface;
use app\core\providers\Data\FieldEnumProvider;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Nomenclature\Unit;
use app\models\Data\Languages;
use app\models\Data\SpecialPriceTypes;
use function GuzzleHttp\json_decode;
/**
 * Description of FormElement
 *
 * @author kotov
 */
abstract class FormElement implements FormElementInterface
{
    protected string $langCode;
    /**
     * 
     * @var Field
     */
    protected $field;
    
    /**
     * 
     * @var array
     */
    protected $fieldParameters;
    
    /**
     * 
     * @var FieldEnumProvider|null
     */
    protected $fieldEnumProvider; 
    
    /**
     * 
     * @var PriceModifyInterface[]
     */
    protected $priceModificators = [];        

    public function __construct(Field $field, FieldEnumProvider $enumProvider = null, string $langCode = Languages::RUSSIAN)
    {
        $this->field = $field;
        $this->fieldParameters = json_decode($this->field->parameters, true);
        $this->langCode = $langCode;
        $this->fieldEnumProvider = $enumProvider;
    }
    
    public function getData(array $valuesList = []): array
    {
        $fieldList = $this->field->toArray();
        return $this->transformData($fieldList, $valuesList);
        
    }  
    
    public function getFieldId(): int
    {
        return $this->field->id;
    }
    
    public function getField(): Field
    {
        return $this->field;
    }    
    
    public function getOrder(): int
    {
        return $this->field->order;
    }

    public function getParameters(): array
    {
        return $this->fieldParameters;
    }
    
    public function isComputed(): bool
    {
        return !!$this->field->getFieldParams()->isComputed;
    }


    public function getTranslatableParameter(string $parameterName): string 
    {
        if (!key_exists($parameterName, $this->fieldParameters)) {
            return '';
        }
        if ($this->langCode == Languages::RUSSIAN) {
            return $this->fieldParameters[$parameterName];
        }
        $parameterEng = $parameterName . 'Eng';
        if (key_exists($parameterEng, $this->fieldParameters) && !empty($this->fieldParameters[$parameterEng])) {
            return $this->fieldParameters[$parameterEng];
        }
        return $this->fieldParameters[$parameterName];
    }

    public function isShowInRequest(): bool 
    {
        return (bool) $this->field->showed_in_request;
    }

    public function isShowInPdf(): bool 
    {
        return (bool) $this->field->showed_in_pdf;
    }
    
    public function isDeleted(): bool
    {
        return  (bool) $this->field->deleted;
    }


    protected function transformData(array $fieldList, array $valuesList):array
    {
        $fieldList['parameters'] = $this->buildParameters($fieldList);
        return $fieldList;
    }
    
    public function addPriceModificator(PriceModificator $priceModificator) :void
    {
        $priceModificator->setFormElement($this);
        array_push($this->priceModificators,$priceModificator);
    }
    



    /**
     * Применить модификаторы стоимости, если они имеются
     * @param int $price
     */
    protected function modifyPrice(int $price) 
    {
        foreach ($this->priceModificators as $priceModificator) {
           $price = $priceModificator->modify($price);
        }
        return $price;
    }
    
    protected function buildParameters(array $fieldList): array
    {
        $result = json_decode($fieldList['parameters'],true);
        if (key_exists('unitPrice', $fieldList)) {
            $result['basePrice'] = $result['unitPrice'];
            $result['unitPrice'] = $result['unitPrice'] ? $this->modifyPrice($result['unitPrice']) : 0;
            $result['modifiers'] = $this->getModifiersInformation();
        }
        if (key_exists('unit', $result) && is_numeric($result['unit'])) {
            $unitId = (int) $result['unit'];
            $unitElement = Unit::findOne($unitId);
            $result['unitName'] = $unitElement ? $unitElement->short_name : '';
        }        
        return $result;
    }
    
    protected function getModifiersInformation(): array
    {
        $result = [];
        foreach ($this->priceModificators as $modificator) {
            $specialPrice = $modificator->getSpecialPriceElement();
            if ($specialPrice) {
                array_push($result,[
                    'value' => $specialPrice->price,
                    'alias' => $modificator->getAlias()
                ]);
            }
        }
        return $result;
    }
}
