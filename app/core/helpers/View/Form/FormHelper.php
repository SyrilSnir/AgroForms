<?php

namespace app\core\helpers\View\Form;

use app\core\helpers\View\Form\FormElements\CountableElementInterface;
use app\core\helpers\View\Form\FormElements\ElementAdditionEquipmentBlock;
use app\core\helpers\View\Form\FormElements\ElementCheckbox;
use app\core\helpers\View\Form\FormElements\ElementCheckNumberInput;
use app\core\helpers\View\Form\FormElements\ElementFrieze;
use app\core\helpers\View\Form\FormElements\ElementGroup;
use app\core\helpers\View\Form\FormElements\ElementHeader;
use app\core\helpers\View\Form\FormElements\ElementImportantInformationBlock;
use app\core\helpers\View\Form\FormElements\ElementInformationBlock;
use app\core\helpers\View\Form\FormElements\ElementNumberInput;
use app\core\helpers\View\Form\FormElements\ElementRadio;
use app\core\helpers\View\Form\FormElements\ElementSelect;
use app\core\helpers\View\Form\FormElements\ElementSelectMultiple;
use app\core\helpers\View\Form\FormElements\ElementTextField;
use app\core\helpers\View\Form\FormElements\ElementUnknown;
use app\core\helpers\View\Form\FormElements\FormElement;
use app\core\helpers\View\Form\FormElements\FormElementInterface;
use app\core\helpers\View\Form\Modificators\CoefficientModificator;
use app\core\helpers\View\Form\Modificators\PercentModificator;
use app\core\helpers\View\Form\Modificators\PriceModificator;
use app\core\helpers\View\Form\Modificators\StaticModificator;
use app\core\providers\Data\FieldEnumProvider;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Application;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Users\User;
use app\models\Data\Languages;
use app\models\Data\SpecialPriceTypes;
use Yii;
use function GuzzleHttp\json_decode;

/**
 * Description of FormHelper
 *
 * @author kotov
 */
class FormHelper extends BaseFormHelper
{
    
    /**
     * 
     * @var FormElementInterface[]
     */
    protected $formElements;    
    
    /**
     * 
     * @var array
     */
    public static $valuesList = [];
  
    public static function createViaForm(User $user, string $langCode, Form $form): self
    {
        $instance = new self($user, $langCode);
        $instance->form = $form;
        $instance->appendFormElements();
        return $instance;
    }
    
    public static function createViaRequest(User $user, string $langCode, Request $request): self
    {
        $instance = new self($user, $langCode);
        $instance->form = $request->form;
        $instance->request = $request;
        $instance->appendRequestValues();
        $instance->appendFormElements();
        return $instance;
    }
    
    public static function getElement(Field $field, string $langCode = Languages::RUSSIAN, int $date = null) : ?FormElementInterface
    {
        /** @var FormElement|null $formElement */
        /** @var PriceModificator $priceModificator */
        $priceModificator = null;
        switch ($field->element_type_id) {
            case ElementType::ELEMENT_HEADER:
                $formElement = new ElementHeader($field, null, $langCode);
                break;
            case ElementType::ELEMENT_INFORMATION:
                $formElement = new ElementInformationBlock($field, null, $langCode);
                break;
            case ElementType::ELEMENT_INFORMATION_IMPORTANT:
                $formElement = new ElementImportantInformationBlock($field, null, $langCode);
                break;
            case ElementType::ELEMENT_TEXT_INPUT:
                $formElement = new ElementTextField($field, null, $langCode);
                break;
            case ElementType::ELEMENT_NUMBER_INPUT:
                $formElement = new ElementNumberInput($field, null, $langCode);
                break;
            case ElementType::ELEMENT_SELECT:
                $formElement = new ElementSelect($field, new FieldEnumProvider(), $langCode);
                break;
            case ElementType::ELEMENT_RADIO_BUTTON:
                $formElement = new ElementRadio($field, new FieldEnumProvider(), $langCode);
                break;
            case ElementType::ELEMENT_CHECKBOX:
                $formElement = new ElementCheckbox($field, null, $langCode);
                break;
            case ElementType::ELEMENT_CHECK_NUMBER_INPUT:
                $formElement = new ElementCheckNumberInput($field, null, $langCode);
                break;
            case ElementType::ELEMET_ADDITIONAL_EQUIPMENT:
                $formElement = new ElementAdditionEquipmentBlock($field, null, $langCode);
                break;
            case ElementType::ELEMENT_SELECT_MULTIPLE:
                $formElement = new ElementSelectMultiple($field, new FieldEnumProvider(), $langCode);
                break;
            case ElementType::ELEMENT_FRIEZE:
                $formElement = new ElementFrieze($field, null, $langCode);
                break;
            case ElementType::ELEMENT_GROUP:
                $formElement = new ElementGroup($field, null, $langCode, self::$valuesList, $date);
                break;
            default: 
                $formElement = new ElementUnknown($field, null, $langCode);
                break;
        }
      
        self::appendPriceModificators($field, $formElement, $date);
        return $formElement;
    }
    
    protected static function appendPriceModificators(Field $field, FormElement $formElement,int $date = null)
    {
        $parameters = $formElement->getParameters();
        if (in_array($field->element_type_id, ElementType::COMPUTED_FIELDS)) {
            if (key_exists('specialPriceType',$parameters)) {
                if($parameters['specialPriceType'] == SpecialPriceTypes::TYPE_VALUTE) {
                    $priceModificator = new StaticModificator($date);
                }
                if($parameters['specialPriceType'] == SpecialPriceTypes::TYPE_PERCENT) {
                    $priceModificator = new PercentModificator($date);
                }
                if ($parameters['specialPriceType'] == SpecialPriceTypes::TYPE_COEFFICIENT) {
                    $priceModificator = new CoefficientModificator($date);
                }
                if ($priceModificator) {
                    $formElement->addPriceModificator($priceModificator);
                }
            }
        }        
    }    
    
    protected function appendFormElements()
    {
        $request = $this->getRequest();
        if (!$request) {
            $date = microtime(true);
        } else {
            $date = $request->updated_at ? $request->updated_at : $request->created_at;
        }
        $this->formElements = [];
        if ($this->form) {
            foreach ($this->form->rootFormFields as $field) {
                $formElement = self::getElement($field, $this->langCode, $date);
                if ($formElement) {
                    array_push($this->formElements,$formElement);
                }
            }
        }
    }
        


    protected function appendRequestValues() 
    {
        /** @var Application $requestForm */
        if (!$this->request) {
            return;
        }
        $requestForm = $this->request->requestForm;
        $valuesList = [];
        $fields = json_decode($requestForm->fields,true);
        foreach ($fields as $id => $field) {
            if (key_exists('value', $field)) {
                $valuesList[$id]['value'] = $field['value'];
            }
            if (key_exists('checked', $field)) {
                $valuesList[$id]['checked'] = $field['checked'];
            }
        }
        self::$valuesList = $valuesList;
    }    
    
    protected function getElements(): array 
    {
        $result = [];
        foreach ($this->formElements as $element) {
            $fieldId = $element->getFieldId();
            $val = [];
            if (key_exists($fieldId, self::$valuesList)) {
                $val = self::$valuesList[$fieldId];
            } 
            if (!$element->isDeleted() || !empty($val)) { 
                $data = $element->getData($val);
                if (!empty($data)) {
                    array_push($result, $element->getData($val));
                }
            }
        }
        return $result;
    }
    
    protected function renderPDFElements(): string 
    {
        $result = '';
        foreach ($this->formElements as $element) {
            if (!$element->isShowInPdf()) {
                continue;
            }
            $fieldId = $element->getFieldId();
            $val = [];
            if (key_exists($fieldId, self::$valuesList)) {
                $val = self::$valuesList[$fieldId];
            } 
            $result.= $element->renderPDF($val);
        }
        return $result;        
    }
    
    protected function renderHtmlElements(): string 
    {
        $result = '';
        foreach ($this->formElements as $element) {
            if (!$element->isShowInRequest()) {
                continue;
            }
            $fieldId = $element->getFieldId();
            $val = [];
            if (key_exists($fieldId, self::$valuesList)) {
                $val = self::$valuesList[$fieldId];
            } 
            if (empty($val) && $element->isDeleted()) {
                continue;
            }
            $result.= $element->renderHtml($val);
        }
        return $result;
    }
    
    protected function getUploadedFileUrl():string
    {
        $request = $this->getRequest();
        if (!$request) {
            return '';
        }
        
        $file = $request->getRequestForm()->getUploadedFileUrl('file');
        return $file ?? '';
    }

    public function getFormPrice() :int 
    {
        $price = $this->form->base_price;
        foreach ($this->formElements as $element) {
            
            if (!$element->isComputed() || !is_subclass_of($element, CountableElementInterface::class)) {
                continue;                
            }
            /** @var CountableElementInterface $element */
            if (is_a($element, ElementGroup::class)) {
                $price += $element->getPrice(self::$valuesList);
            } else {
                $fieldId = $element->getFieldId();
                if (key_exists($fieldId, self::$valuesList)) {
                    $val = self::$valuesList[$fieldId];
                    if (!empty($val)) {
                        $price += $element->getPrice($val);
                    }
                }       
            }
            
        }        
        return $price;
    }
    public function renderHtmlRequest() :string 
    {
        $requestData = [
            'form' => $this->form,  
            'elements' => $this->renderHtmlElements(),
            'request' => $this->request,
            'amount' => $this->getFormPrice(),
            'attachedFile' => $this->getUploadedFileUrl(),
        ];
        return Yii::$app->view->renderFile(Yii::getAlias('@elements'). DIRECTORY_SEPARATOR . 'request-html.php', $requestData);
    }
    
    public function getData(bool $isReadOnly = false) :array
    {
        $formData = [
            'userId' => $this->user->id,
            'companyId' => $this->user->company_id,
            'title' => $this->form->headerName,
            'formType' => $this->form->form_type_id,
            'formId' => $this->form->id,
            'attachedFile' => $this->getUploadedFileUrl(),
          //  'companyId' =>// $this->
            'hasFile' => (bool) $this->form->has_file,
            'readOnly' => $isReadOnly,
            'language' => $this->langCode,
            'dict' => [
                'symbol'  => t('symb.','requests'),
                'addSymbols' => t('Additional symbols', 'requests'),
                'fileAttach' => [
                    'browse' => t('Browse'),
                    'selectFile' => t('Select file'),
                    'attachFile' => t('Attach file'),
                    'amount' => $this->getFormPrice(),                    

                ],
                'valute' => t($this->form->valute->char_code, 'requests'),
                'total' => [
                    'totalMsg' => t('Total','requests'),
                    'totalHead' => t('Total amount payable','requests'),
                ],                  
                'buttons' => [
                    'send' => t('Send application','requests'),
                    'draft' => t('Save draft', 'requests'),
                    'cancel' => t('Cancel'),
                    'close' => t('Close'),
                ], 
            ], 
        ];
        
        $formData['elements'] = $this->getElements();
        if ($this->form->form_type_id == FormType::DYNAMIC_ORDER_FORM) {
            $formData['basePrice'] = $this->form->base_price;
            $formData['computed'] = true;
        } else {
            $formData['computed'] = false;
            $formData['basePrice'] = 0;
        }
        return $formData;
    }

    public function renderPDF(): mixed
    {
        
        $content = Yii::$app->view->renderFile('@pdf/dynamic-form.php',[
            'model' => $this->request,
            'fields' => $this->formElements,
            'values' => self::$valuesList,
            'amount' => $this->getFormPrice(),
        ]);
        $header = $this->getPdfHeader();
        $footer = $this->getPdfFooter();
        
        //$content = 'Превед';
        $this->pdfHelper->methods = [
                'SetHeader'=>[$header], 
                'SetFooter'=>[$footer],
                'SetTitle' =>  t('Application №','requests') . $this->request->id,
        ];
        $this->pdfHelper->content = $content;
        return $this->pdfHelper->render();
    }

}
