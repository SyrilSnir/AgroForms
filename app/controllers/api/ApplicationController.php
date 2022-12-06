<?php

namespace app\controllers\api;

use app\core\helpers\View\Form\FormHelper;
use app\core\manage\Auth\UserIdentity;
use app\core\repositories\manage\Forms\FormRepository;
use app\core\repositories\manage\Requests\RequestRepository;
use app\core\services\Forms\FieldService;
use app\core\services\operations\Requests\ApplicationService;
use app\core\services\operations\Requests\AttachedFilesService;
use app\core\services\operations\View\Requests\ApplicationViewService;
use app\core\traits\InfoMessageTrait;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\AttachedFilesForm;
use app\models\Forms\Requests\DynamicForm;
use app\models\Forms\Requests\RemoveAttachmentForm;
use DomainException;
use Yii;

/**
 * Description of DynamicFormController
 *
 * @author kotov
 */
class ApplicationController extends FormController
{ 
    /**
     *
     * @var FieldService
     */
    protected $fieldService;
    
    /**
     * 
     * @var AttachedFilesService
     */
    protected $attachedFilesService;


    /**
     *
     * @var ApplicationService
     */
    protected $applicationService;
    /**
     *
     * @var FormRepository
     */
    protected $formRepository;
    /**
     *
     * @var RequestRepository
     */
    protected $requestRepository;
    
    /**
     *
     * @var ApplicationViewService
     */
    protected $applicationViewService;    

    use InfoMessageTrait;
    
    public function __construct(
            $id, 
            $module, 
            FormRepository $formRepository,
            RequestRepository $requestRepository,
            ApplicationService $applicationService,
            ApplicationViewService $applicationViewService,
            FieldService $fieldService,
            AttachedFilesService $attachedService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->formRepository = $formRepository;
        $this->requestRepository = $requestRepository;
        $this->fieldService = $fieldService;
        $this->applicationService = $applicationService;
        $this->applicationViewService = $applicationViewService;
        $this->attachedFilesService = $attachedService;
    } 
    
    public function actionRemoveAttachment()
    {
        $form = new RemoveAttachmentForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->attachedFilesService->remove($form);
            return $this->getMessage('OK');
        }
        $message = t('An error occurred while saving the application form', 'exception');            
        return $this->getErrorMessage($message);        
        
    }
    
    public function actionGetForm($readonly = false)
    {
        /** @var Form $form */
        /** @var Request $request */
        /** @var UserIdentity $userIdentity */
        $formId = Yii::$app->session->get('OPENED_FORM_ID');
        $langCode = Yii::$app->language;
        if (!$formId) {
            throw new DomainException(t('The requested form was not found on the server', 'exception'));
        }
        $userIdentity = Yii::$app->user->getIdentity(); 
        $form = $this->formRepository->get($formId);
        
        $formChangeType = Yii::$app->session->get('FORM_CHANGE_TYPE', Request::FORM_CREATE);
        if ($formChangeType === Request::FORM_UPDATE) {
            $requestId = Yii::$app->session->get('REQUEST_ID');            
            $request = $this->requestRepository->getForUser($requestId,$userIdentity->getId());            
            $formHelper = FormHelper::createViaRequest($userIdentity->getUser(), $langCode, $request);
        } else {     
            $formHelper = FormHelper::createViaForm($userIdentity->getUser(), $langCode, $form);
        }
        return $formHelper->getData($readonly);
    }

    public function actionSendForm()
    {
        /** @var Form $appForm */
        $form = new DynamicForm();
        $attachedForm = new AttachedFilesForm();
                
        $formChangeType = Yii::$app->session->get('FORM_CHANGE_TYPE');
        try {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                if ($formChangeType === Request::FORM_UPDATE) {
                    $requestId = Yii::$app->session->get('REQUEST_ID');
             /** @var Request $request */
                    $request = $this->updateRequest($requestId, $form);                                        
                } else {
                    $request = $this->createRequest($form);
                }
                if ($attachedForm->load(Yii::$app->request->post()) && $attachedForm->validate()) {
                    foreach ($attachedForm->fileFields as $index => $fieldId) {
                        $this->attachedFilesService->create($request->id, $fieldId, $attachedForm->files[$index]);
                    }
                }                
                $appForm = $this->formRepository->get($form->formId); 
                
                return [
                    'exhibitionId' => $appForm->exhibition_id,
                    'contractId' => $form->contractId,
                ];               
            }
        } catch (Exception $e) {
            $message = t('An error occurred while saving the application form', 'exception');            
            return $this->getErrorMessage($message);
        }        
    }

    private function createRequest(DynamicForm $form): Request
    {
        $request = $this->applicationService->create($form); 
        return $request;
    }
    
    private function updateRequest(int $requestId, DynamicForm $form): Request
    {
        /** @var Request $request */
        $request = $this->requestRepository->get($requestId);
        $this->applicationService->edit($request, $form, Yii::$app->language);   
        return $request;
    }      

}
