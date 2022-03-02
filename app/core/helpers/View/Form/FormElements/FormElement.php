<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\providers\Data\FieldEnumProvider;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\Data\Languages;
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
     * @var FieldEnumProvider|null
     */
    protected $fieldEnumProvider; 
    
    public function __construct(Field $field, FieldEnumProvider $enumProvider = null, string $langCode = Languages::RUSSIAN)
    {
        $this->field = $field;
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
        return json_decode($this->field->parameters, true);
    }

    public function isShowInRequest():bool 
    {
        return (bool) $this->field->showed_in_request;
    }
    
    protected function transformData(array $fieldList, array $valuesList):array
    {
        $fieldList['parameters'] = json_decode($fieldList['parameters']);
        return $fieldList;
    }

    public static function getElement(Field $field) : ?FormElementInterface
    {
        $formElement = null;
        switch ($field->element_type_id) {
            case ElementType::ELEMENT_HEADER:
                $formElement = new ElementHeader($field);
                break;
            case ElementType::ELEMENT_INFORMATION:
                $formElement = new ElementInformationBlock($field);
                break;
            case ElementType::ELEMENT_INFORMATION_IMPORTANT:
                $formElement = new ElementImportantInformationBlock($field);
                break;
            case ElementType::ELEMENT_SELECT:
                $formElement = new ElementSelect($field, new FieldEnumProvider());
                break;
            case ElementType::ELEMENT_CHECKBOX:
                $formElement = new ElementCheckbox($field);
                break;
            case ElementType::ELEMENT_CHECK_NUMBER_INPUT:
                $formElement = new ElementCheckNumberInput($field);
                break;
            case ElementType::ELEMET_ADDITIONAL_EQUIPMENT:
                $formElement = new ElementAdditionEquipmentBlock($field);
                break;
        }
        
        return $formElement;
    }
}
