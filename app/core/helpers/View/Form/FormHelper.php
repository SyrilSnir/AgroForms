<?php

namespace app\core\helpers\View\Form;

use app\core\helpers\View\Form\FormElements\FormElementInterface;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Requests\Request;

/**
 * Description of FormHelper
 *
 * @author kotov
 */
class FormHelper
{
    /**
     * 
     * @var Form
     */
    protected $form;
    
    /**
     * 
     * @var Request|null
     */
    protected $request;
    
    /**
     * 
     * @var FormElementInterface[]
     */
    protected $formElements;
    
    /**
     * 
     * @var int
     */
    protected $userId;
    
    /**
     * 
     * @var string
     */
    protected $langCode;


    private function __construct(int $usetId, string $langCode) 
    {
        $this->userId = $usetId;
        $this->langCode = $langCode;        
    }
    
    public static function createViaForm(int $userId, string $langCode, Form $form): self
    {
        $instance = new self($userId, $langCode);
        $instance->form = $form;
        return $instance;
    }
    
    public static function createViaRequest(int $userId, string $langCode, Request $request): self
    {
        $instance = new self($userId, $langCode);
        $instance->form = $request->form;
        $instance->request = $request;
        return $instance;
    }
    
    protected function appendFormElements()
    {
        $this->formElements = [];
        if ($this->form) {
            foreach ($this->form->formFields as $field) {
                switch ($field->element_type_id) {
                    case ElementType::ELEMENT_HEADER:
                        break;
                }
            }
        }
    }
    
    public function getData() :array
    {
        $formData = [
            'userId' => $this->userId,
            'title' => $this->form->headerName,
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
        return $formData;
    }            
}
