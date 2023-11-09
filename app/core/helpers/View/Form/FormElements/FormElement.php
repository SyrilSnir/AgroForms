<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\helpers\View\Form\ExcelHeaderView;
use app\core\helpers\View\Form\Modificators\PriceModificator;
use app\core\helpers\View\Form\PriceModifyInterface;
use app\core\providers\Data\FieldEnumProvider;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Nomenclature\Unit;
use app\models\Data\Languages;
use Yii;
use yii\web\View;
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
    
    /**
     * 
     * @var ?int
     */
    protected $requestId;
    
    /**
     * 
     * @var View
     */
    protected $view;

    public function __construct(Field $field, FieldEnumProvider $enumProvider = null, string $langCode = Languages::RUSSIAN)
    {
        $this->field = $field;
        $this->fieldParameters = json_decode($this->field->parameters, true);
        $this->langCode = $langCode;
        $this->fieldEnumProvider = $enumProvider;
        $this->view = Yii::$app->view;
    }
    public function isEmpty(array $valuesList = []): bool
    {
        return !(key_exists('value', $valuesList) && !empty($valuesList['value']));
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
        $fieldParams = $this->field->getFieldParams();
        if (!property_exists($fieldParams,'isComputed')) {
            return false;
        }
        return !!$fieldParams->isComputed;
    }

    public function setRequestId(int $id): void
    {
        $this->requestId = $id;
    }

    public function getRequestId(): ?int
    {
        return $this->requestId;
    }
    
    public function getElements(): array
    {
        return [];
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
    
    public function isExcelExport(): bool 
    {
        return (bool) $this->field->to_export;
    }


    public function isDeleted(): bool
    {
        return  (bool) $this->field->deleted;
    }
    
    public function isGroup():bool {
        return $this->field->element_type_id == ElementType::ELEMENT_GROUP;
    }

    protected function transformData(array $fieldList, array $valuesList):array
    {
        $fieldList['parameters'] = $this->buildParameters($fieldList);
        if (key_exists('unitPrice',$fieldList['parameters'])) {
            $fieldList['parameters']['unitPrice'] = $this->modifyPrice((int)$fieldList['parameters']['unitPrice']); 
        }
        return $fieldList;
    }
    
    public function addPriceModificator(PriceModificator $priceModificator) :void
    {
        $priceModificator->setFormElement($this);
        array_push($this->priceModificators,$priceModificator);
    }
    
    public function getLenght(): int 
    {
        if ($this->isExcelExport()) {
            return 1;
        }
        return 0;
    }
    
    public function getExcelHeader(): ExcelHeaderView 
    {
        return new ExcelHeaderView($this->getField()->name, $this->getLenght());
    }
    
    public function getExcelValue(array $valuesList = []): array|string
    {
        return '';
    }

    /**
     * Применить модификаторы стоимости, если они имеются
     * @param int $price
     */
    public function modifyPrice(int $price) 
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
    
    public function getCatalogData(array $valuesList): array
    {
        $label = $this->field->label->code;
        $value = $valuesList['value'];
        return [
            'label' => $label,
            'value' => $value,
        ];
    }
}
