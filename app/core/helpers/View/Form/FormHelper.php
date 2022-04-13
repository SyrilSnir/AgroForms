<?php

namespace app\core\helpers\View\Form;

use app\core\helpers\View\Form\FormElements\CountableElementInterface;
use app\core\helpers\View\Form\FormElements\FormElement;
use app\core\helpers\View\Form\FormElements\FormElementInterface;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Application;
use app\models\ActiveRecord\Requests\Request;
use Yii;

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
    protected $valuesList = [];
  
    public static function createViaForm(int $userId, string $langCode, Form $form): self
    {
        $instance = new self($userId, $langCode);
        $instance->form = $form;
        $instance->appendFormElements();
        return $instance;
    }
    
    public static function createViaRequest(int $userId, string $langCode, Request $request): self
    {
        $instance = new self($userId, $langCode);
        $instance->form = $request->form;
        $instance->request = $request;
        $instance->appendFormElements();
        $instance->appendRequestValues();
        return $instance;
    }
    
    protected function appendFormElements()
    {
        $this->formElements = [];
        if ($this->form) {
            foreach ($this->form->formFields as $field) {
                $formElement = FormElement::getElement($field, $this->langCode);
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
        $this->valuesList = $valuesList;
    }    
    
    protected function getElements(): array 
    {
        $result = [];
        foreach ($this->formElements as $element) {
            $fieldId = $element->getFieldId();
            $val = [];
            if (key_exists($fieldId, $this->valuesList)) {
                $val = $this->valuesList[$fieldId];
            } 
            if (!$element->isDeleted() || !empty($val)) { 
                array_push($result, $element->getData($val));
            }
        }
        return $result;
    }
    
    protected function renderPDFElements(): string 
    {
        $result = '';
        foreach ($this->formElements as $element) {
            if (!$element->isShowInRequest()) {
                continue;
            }
            $fieldId = $element->getFieldId();
            $val = [];
            if (key_exists($fieldId, $this->valuesList)) {
                $val = $this->valuesList[$fieldId];
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
            if (key_exists($fieldId, $this->valuesList)) {
                $val = $this->valuesList[$fieldId];
            } 
            if (empty($val) && $element->isDeleted()) {
                continue;
            }
            $result.= $element->renderHtml($val);
        }
        return $result;
    }

    public function getFormPrice() :int 
    {
        $price = $this->form->base_price;
        foreach ($this->formElements as $element) {
            
            if (!$element->isComputed() || !is_subclass_of($element, CountableElementInterface::class)) {
                continue;                
            }
            /** @var CountableElementInterface $element */
            $fieldId = $element->getFieldId();
            if (key_exists($fieldId, $this->valuesList)) {
                $val = $this->valuesList[$fieldId];
                if (!empty($val)) {
                    $price += $element->getPrice($val);
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
        ];
        return Yii::$app->view->renderFile(Yii::getAlias('@elements'). DIRECTORY_SEPARATOR . 'request-html.php', $requestData);
    }
    
    public function getData(bool $isReadOnly = false) :array
    {
        $formData = [
            'userId' => $this->userId,
            'title' => $this->form->headerName,
            'formType' => $this->form->form_type_id,
            'formId' => $this->form->id,
            'hasFile' => (bool) $this->form->has_file,
            'readOnly' => $isReadOnly,
            'language' => $this->langCode,
            'dict' => [
                'fileAttach' => [
                    'browse' => t('Browse'),
                    'selectFile' => t('Select file'),
                    'attachFile' => t('Attach file'),

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
        $exhibitionName = $this->form->exhibition->title;
        
        $content = Yii::$app->view->renderFile('@pdf/dynamic-form.php',[
            'model' => $this->request,
            'fields' => $this->formElements,
            'values' => $this->valuesList
        ]);
        $footer = $this->getPdfFooter();
        
        //$content = 'Превед';
        $this->pdfHelper->methods = [
                'SetHeader'=>[$exhibitionName], 
                'SetFooter'=>[$footer],
                'SetTitle' =>  t('Application №','requests') . $this->request->id,
        ];
        $this->pdfHelper->content = $content;
        return $this->pdfHelper->render();
    }

}
