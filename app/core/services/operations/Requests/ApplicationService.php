<?php

namespace app\core\services\operations\Requests;

use app\core\helpers\View\Form\FormHelper;
use app\core\repositories\manage\Forms\FormRepository;
use app\core\repositories\manage\Requests\ApplicationRepository;
use app\core\repositories\manage\Requests\RequestRepository;
use app\core\services\Forms\FieldService;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Application;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\AttachedFilesForm;
use app\models\Forms\Requests\DynamicForm;
use Yii;
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
     * @var FormRepository
     */
    public $form;
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
            FormRepository $formRepository,
            FieldService $fieldService
            )
    {
        $this->application = $application;        
        $this->requests = $requests;
        $this->fieldService = $fieldService;
        $this->form = $formRepository;
    }
    
    public function create(DynamicForm $form)
    {    
        /** @var Form $appForm */
        $fields = $this->fieldService->prepareFieldsBeforeSave($form->fields);
        $appForm = $this->form->get($form->formId);
        $exhibitionId = $appForm->exhibition_id;
        $serializedFields = json_encode($fields);
       // $total = $this->fieldService->calculateTotal($fields,$form->basePrice); 
        /** @var Request $request */   
        $request = Request::create(
                $form->userId, 
                $form->formId,
                $exhibitionId, 
                $form->companyId,
                $form->contractId,
                FormType::DYNAMIC_ORDER_FORM,
                $form->draft
                );
        if (!$form->draft) {
            $request->activate();
        }
        $this->requests->save($request);
        $application = Application::create(
                $request->id, 
                $form->formId,
                $serializedFields,
                0
                );
        if ($form->loadedFile) {
           $application->setFile($form->loadedFile);
        }
        $this->application->save($application);        
        $this->setApplicationTotal($request, $application);
        return $request;
    }
    
    public function edit(Request $request, DynamicForm $form, string $langCode)
    {
        /** @var Application $application */
        $formHelper = FormHelper::createViaRequest($request->user, $langCode, $request);
        $fields = $this->fieldService->prepareFieldsBeforeSave($form->fields);
        $serializedFields = json_encode($fields);    
    //    $total = $this->fieldService->calculateTotal($fields,$form->basePrice);
        $total = $formHelper->getFormPrice();
        $form->draft ? 
                $request->setStatusDraft() : (
                    $request->was_rejected ? 
                        $request->setStatusChanged() : 
                        $request->setStatusNew() );
        if (!$form->draft) {
            $request->activate();
        }
        $this->requests->save($request);        
        $application = $this->application->findByRequest($request->id);
        $application->edit($serializedFields, $total);
        if ($form->loadedFile) {
           $application->setFile($form->loadedFile);
        }        
        $this->application->save($application); 
        $this->setApplicationTotal($request, $application);  
        return $request;
    }
    
    protected function setApplicationTotal(Request $request, Application $application): Application
    {
        $formHelper = FormHelper::createViaRequest(Yii::$app->user->getIdentity()->getUser(), Yii::$app->language, $request);
        $total = $formHelper->getFormPrice();
        if ($total > 0) {
            $application->amount = $total;
            $this->application->save($application);            
        }        
        return $application;        
    }
}
