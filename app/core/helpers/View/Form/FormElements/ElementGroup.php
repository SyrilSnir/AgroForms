<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\helpers\View\Form\FormElementsManagementTrait;
use app\core\helpers\View\Form\FormHelper;
use app\core\providers\Data\FieldEnumProvider;
use app\models\ActiveRecord\Forms\Field;
use app\models\Data\Languages;
use app\models\Forms\Manage\Forms\Parameters\BaseParametersForm;

/**
 * Description of ElementGroup
 *
 * @author kotov
 */
class ElementGroup extends FormElement implements CountableElementInterface
{
    /**
     * 
     * @var array
     */
    protected $valuesList;
    
    /**
     * 
     * @var int|null
     */
    protected $date;
    
    /**
     * 
     * @var FormElementInterface[]
     */
    protected $formElements = [];    
    
    /**
     * 
     * @var int
     */
    protected $groupType = 0;

    use FormElementsManagementTrait;
    
    /**
     * 
     * @param Field $field
     * @param FieldEnumProvider $enumProvider
     * @param string $langCode
     * @param array $valuesList
     * @param int|null $date
     */
    public function __construct(Field $field, FieldEnumProvider $enumProvider = null, string $langCode = Languages::RUSSIAN, $valuesList = [], int $date = null)
    {        
        parent::__construct($field, $enumProvider, $langCode);
        $parameters = $this->getParameters();
        $this->valuesList = $valuesList;
        $this->date = $date;
        if (key_exists('groupType', $parameters)) {
            $this->groupType = (int) $parameters['groupType'];
        }
        $this->appendFormElements();
    }
    
    public function isComputed(): bool
    {
        return true;
    }    
    
    public function getData(array $valuesList = []): array
    {
        if ($this->groupType == BaseParametersForm::HIDDEN_GROUP_TYPE) {
            return [];
        }        
        return parent::getData($valuesList);
    }

    protected function buildParameters(array $fieldList): array
    {
        $result = parent::buildParameters($fieldList);
        $result['elements'] = [];        
        foreach ($this->formElements  as $element) {
            $fieldId = $element->getFieldId();
            $val = [];
            if (key_exists($fieldId, $this->valuesList)) {
                $val = $this->valuesList[$fieldId];
            } 
            if (!$element->isDeleted() || !empty($val)) { 
                array_push($result['elements'], $element->getData($val));
            }            
        }
        return $result;
    }
    
    protected function appendFormElements()
    {       
        $groupFields = $this->field->getFieldsInGroup();
        foreach ($groupFields as $groupField) {
            $element = FormHelper::getElement($groupField, $this->langCode, $this->date);                        
            if ($element) {
                array_push($this->formElements,$element);
            }
        }
    }

    //put your code here
    public function getPrice(array $valuesList = []): int
    {
        $price = 0;
        foreach($this->formElements as $element) {  
            if ($element->isComputed()) {
                $fieldId = $element->getFieldId();
                $val = [];
                if (key_exists($fieldId, $this->valuesList)) {
                    $val = $this->valuesList[$fieldId];
                }                 
                $price += $element->getPrice($val);
            }
        }
        return $price;
    }

    public function renderHtml(array $valuesList = []): string
    {
        $price = $this->getPrice();
        if ($this->groupType == BaseParametersForm::HIDDEN_GROUP_TYPE) {
            return '';
        }
        if ($this->groupType == BaseParametersForm::CONDITIONALLY_HIDDEN_GROP_TYPE && $price <= 0) {
            return '';
        }
        $result = '';
        foreach($this->formElements as $element) {  
            if (!$element->isShowInRequest()) {
                continue;
            }            
            $val = [];
            $fieldId = $element->getFieldId();
            if (key_exists($fieldId, $this->valuesList)) {
                $val = $this->valuesList[$fieldId];
            }             
            $result.= $element->renderHtml($val);
        }        
        return $result;
    }

    public function renderPDF(array $valuesList = []): string
    {
        $result = '';
        $price = $this->getPrice();        
        if ($this->groupType == BaseParametersForm::HIDDEN_GROUP_TYPE) {
            return '';
        }
        if ($this->groupType == BaseParametersForm::CONDITIONALLY_HIDDEN_GROP_TYPE && $price <= 0) {
            return '';
        }        
        foreach($this->formElements as $element) {  
            if (!$element->isShowInPdf()) {
                continue;
            }            
            $val = [];
            $fieldId = $element->getFieldId();
            if (key_exists($fieldId, $this->valuesList)) {
                $val = $this->valuesList[$fieldId];
            }            
            $result.= $element->renderPDF($val);
        }        
        return $result;
    }

}
