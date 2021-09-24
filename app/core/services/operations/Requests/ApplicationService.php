<?php

namespace app\core\services\operations\Requests;

use app\core\repositories\manage\Requests\ApplicationRepository;
use app\core\repositories\manage\Requests\RequestRepository;
use app\core\services\Forms\FieldService;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Application;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ApplicationForm;
use app\models\Forms\Requests\DynamicForm;
use function GuzzleHttp\json_encode;

/**
 * Description of RequestDynamicFormService
 *
 * @author kotov
 */
class ApplicationService
{
    /**
     *
     * @var ApplicationRepository
     */
    public $application;
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
            ApplicationRepository $application, 
            RequestRepository $requests,
            FieldService $fieldService
            )
    {
        $this->application = $application;        
        $this->requests = $requests;
        $this->fieldService = $fieldService;                
    }
    
    public function create(ApplicationForm $form, $exhibitionId)
    {        
        $fields = $this->fieldService->prepareFieldsBeforeSave($form->fields);
        $serializedFields = json_encode($fields);
        $total = $this->fieldService->calculateTotal($fields,$form->basePrice); 
        /** @var Request $request */   
        $request = Request::create(
                $form->userId, 
                $exhibitionId, 
                $form->draft,
                FormType::DYNAMIC_ORDER_FORM
                );
        $this->requests->save($request);
        $dynamicForm = Application::create(
                $request->id, 
                $form->formId,
                $serializedFields,
                $total
                );
        if ($form->loadedFile) {
           $dynamicForm->setFile($form->loadedFile);
        }
        $this->application->save($dynamicForm);
        return $dynamicForm;        
    }
    
    public function edit($id, ApplicationForm $form)
    {
        /** @var Application $dynamicForm */
        /** @var Request $request */
        
        $fields = $this->fieldService->prepareFieldsBeforeSave($form->fields);
        $serializedFields = json_encode($fields);    
        $total = $this->fieldService->calculateTotal($fields,$form->basePrice);

        $request = $this->requests->get($id);
        $request->edit(
                $form->userId
                );
        $form->draft ? $request->setStatusDraft() : $request->setStatusNew();        
        $this->requests->save($request);        
        $dynamicForm = $this->application->findByRequest($id);
        $dynamicForm->edit($serializedFields, $total);
        if ($form->loadedFile) {
           $dynamicForm->setFile($form->loadedFile);
        }        
        $this->application->save($dynamicForm);    
        
    }
}
