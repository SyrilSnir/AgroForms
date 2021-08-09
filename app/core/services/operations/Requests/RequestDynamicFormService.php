<?php

namespace app\core\services\operations\Requests;

use app\core\repositories\manage\Requests\RequestDynamicFormRepository;
use app\core\repositories\manage\Requests\RequestRepository;
use app\core\services\Forms\FieldService;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestDynamicForm;
use app\models\Forms\Requests\DynamicForm;
use function GuzzleHttp\json_encode;

/**
 * Description of RequestDynamicFormService
 *
 * @author kotov
 */
class RequestDynamicFormService
{
    /**
     *
     * @var RequestDynamicFormRepository
     */
    public $requestDynamicForms;
    /**
     *
     * @var RequestRepository
     */
    public $requests;  
    
    /**
     *
     * @var FieldService
     */
    protected $fieldService;
    
    public function __construct(
            RequestDynamicFormRepository $requestDynamicForms, 
            RequestRepository $requests,
            FieldService $fieldService
            )
    {
        $this->requestDynamicForms = $requestDynamicForms;        
        $this->requests = $requests;
        $this->fieldService = $fieldService;                
    }
    
    public function create(DynamicForm $form, $exhibitionId)
    {        
        $fields = $this->fieldService->prepareFieldsBeforeSave($form->fields);
        $serializedFields = json_encode($fields);
        if ($form->formType == FormType::DYNAMIC_ORDER_FORM) {
            $total = $this->fieldService->calculateTotal($fields,$form->basePrice);
        } else 
        {
            $total = 0;
        }  
        /** @var Request $request */   
        $request = Request::create($form->userId, $form->formId, $exhibitionId, $form->draft);
        $this->requests->save($request);
        $dynamicForm = RequestDynamicForm::create(
                $request->id, 
                $serializedFields, 
                $total
                );
        if ($form->loadedFile) {
           $dynamicForm->setFile($form->loadedFile);
        }
        $this->requestDynamicForms->save($dynamicForm);
        return $dynamicForm;        
    }
    
    public function edit($id, DynamicForm $form)
    {
        /** @var RequestDynamicForm $dynamicForm */
        /** @var Request $request */
        
        $fields = $this->fieldService->prepareFieldsBeforeSave($form->fields);
        $serializedFields = json_encode($fields);    
        if ($form->formType == FormType::DYNAMIC_ORDER_FORM) {
            $total = $this->fieldService->calculateTotal($fields,$form->basePrice);
        } else 
        {
            $total = 0;
        } 
        $request = $this->requests->get($id);
        $request->edit(
                $form->userId, 
                $form->formId
                );
        $form->draft ? $request->setStatusDraft() : $request->setStatusNew();        
        $this->requests->save($request);        
        $dynamicForm = $request->requestForm;
        $dynamicForm->edit($request->id, $serializedFields, $total);
        if ($form->loadedFile) {
           $dynamicForm->setFile($form->loadedFile);
        }        
        $this->requestDynamicForms->save($dynamicForm);    
        
    }
}
