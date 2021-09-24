<?php

namespace app\controllers\api;

use app\core\helpers\Data\Form\FieldGroupsHelper;
use app\core\helpers\Data\Form\FieldsHelper;
use app\core\repositories\manage\Forms\FormRepository;
use app\core\repositories\manage\Requests\RequestRepository;
use app\core\services\Forms\FieldService;
use app\core\services\operations\Requests\ApplicationService;
use app\core\services\operations\View\Requests\ApplicationViewService;
use app\core\traits\InfoMessageTrait;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ApplicationForm;
use app\models\Forms\Requests\DynamicForm;
use DomainException;
use Yii;
use yii\helpers\ArrayHelper;

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
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->formRepository = $formRepository;
        $this->requestRepository = $requestRepository;
        $this->fieldService = $fieldService;
        $this->applicationService = $applicationService;
        $this->applicationViewService = $applicationViewService;
    }    
    public function actionGetForm()
    {
        /** @var Form $form */
        $formId = Yii::$app->session->get('OPENED_FORM_ID');
        $userId = Yii::$app->user->getId();  
        $valuesList = [];
        if (!$formId) {
            throw new DomainException('Запрашиваемая форма не найдена на сервере');
        }
        $formChangeType = Yii::$app->session->get('FORM_CHANGE_TYPE', Request::FORM_CREATE);
        $form = $this->formRepository->get($formId);
        $baseConfiguration = [
          'title' => $form->headerName,
          'userId' => $userId,
          'formType' => $form->form_type_id,
          'formId' => $form->id,
          'hasFile' => (bool) $form->has_file,
          'language' => Yii::$app->language,
          'dict' => [
              'fileAttach' => [
                  'browse' => t('Browse'),
                  'selectFile' => t('Select file'),
                  'attachFile' => t('Attach file'),
              ],
              'valute' => t($form->valute->char_code, 'requests'),
              'total' => [
                'totalMsg' => t('Total','requests'),
                'totalHead' => t('Total amount payable','requests'),
              ],
              'buttons' => [
                'send' => t('Send application','requests'),
                'draft' => t('Save draft', 'requests'),
                'cancel' => t('Cancel'),
              ]
          ]
        ]; 
        
        if ($formChangeType === Request::FORM_UPDATE) {
            $requestId = Yii::$app->session->get('REQUEST_ID');            
            /** @var Request $request */
           $request = $this->requestRepository->getForUser($requestId,$userId);
           $valuesList = $this->applicationViewService->getValuesList($request->requestForm);
           $baseConfiguration['fileName'] = $request->requestForm->file;
        }               
        if ($form->form_type_id == FormType::DYNAMIC_ORDER_FORM) {
            $baseConfiguration['computed'] = true;
            $baseConfiguration['basePrice'] = $form->base_price;
        } else {
            $baseConfiguration['computed'] = false;
            $baseConfiguration['basePrice'] = 0;
        }

       $groups = FieldGroupsHelper::getGroupsWithFields($formId);
       $groups = array_map(function($elem) {
                $elem['isGroup'] = true;
                return $elem;
            }, $groups);
       $fields = FieldsHelper::getUncategorizedFields($formId);
       $formElements = ArrayHelper::merge($groups, $fields);
        ArrayHelper::multisort($formElements,['order'],[SORT_ASC]);
       
       $this->fieldService->postProcessFields($formElements,$valuesList);
        $baseConfiguration['elements'] = $formElements;
        return $baseConfiguration;
        
    }

    public function actionSendForm()
    {
        $form = new ApplicationForm();
        $formChangeType = Yii::$app->session->get('FORM_CHANGE_TYPE');
        try {
            if ($form->load(Yii::$app->request->post(),'DynamicForm') && $form->validate()) {
                if ($formChangeType === Request::FORM_UPDATE) {
                    $requestId = Yii::$app->session->get('REQUEST_ID');
             /** @var Request $request */
                    $this->updateRequest($requestId, $form);                                        
                } else {
                    $this->createRequest($form);
                }
                return [
                    'exhibitionId' => Yii::$app->params['activeExhibition']
                ];               
            }
        } catch (Exception $e) {
            $message = 'Произошла ошибка при сохранении формы заявки';            
            return $this->getErrorMessage($message);
        }        
    }

    private function createRequest(ApplicationForm $form)
    {
       $this->applicationService->create($form,Yii::$app->params['activeExhibition']); 
    }
    
    private function updateRequest(int $requestId, ApplicationForm $form)
    {
        /** @var Request $request */
        $request = $this->requestRepository->get($requestId);
        $this->applicationService->edit($requestId, $form);   
    }    

}
