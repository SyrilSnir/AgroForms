<?php

namespace app\controllers\api;

use app\core\helpers\Data\ConfigurationHelper;
use app\core\helpers\Data\StandsHelper;
use app\core\repositories\manage\Forms\FormRepository;
use app\core\repositories\manage\Requests\RequestRepository;
use app\core\services\operations\Requests\RequestStandService;
use app\core\traits\InfoMessageTrait;
use app\models\ActiveRecord\Configuration;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestStand;
use app\models\Forms\Requests\StandForm;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of FormsController
 *
 * @author kotov
 */
class StandController extends FormController
{
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
     * @var RequestStandService
     */
    protected $requestStandService;
    
    use InfoMessageTrait;
    
    public function __construct(
            $id, 
            $module, 
            FormRepository $formRepository,
            RequestRepository $requestRepository,
            RequestStandService $requestStandService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->formRepository = $formRepository;
        $this->requestRepository = $requestRepository;
        $this->requestStandService = $requestStandService;
    }
    
    public function actionGetForm($readonly = false)
    {
        /** @var Form $stand */
        $formId = Yii::$app->session->get('OPENED_FORM_ID');
        $langCode = Yii::$app->language;
        if (!$formId) {
            throw new DomainException(t('The requested form was not found on the server', 'exception'));
        }
        $form = $this->formRepository->get($formId);        
        $userId = Yii::$app->user->getId();
        $formChangeType = Yii::$app->session->get('FORM_CHANGE_TYPE', Request::FORM_CREATE);
        if ($formChangeType === Request::FORM_UPDATE) {
            $requestId = Yii::$app->session->get('REQUEST_ID');
            $request = $this->requestRepository->getForUser($requestId, $userId);            
            $formHelper = \app\core\helpers\View\Form\StandHelper::createViaRequest($userId, $langCode, $request);
        } else {
            $formHelper = \app\core\helpers\View\Form\StandHelper::createViaForm($userId, $langCode, $form);
        }
        return $formHelper->getData($readonly);
    }
    
    public function actionSendForm() 
    {
        $form = new StandForm();
        $formChangeType = Yii::$app->session->get('FORM_CHANGE_TYPE');
        try {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                if ($formChangeType === Request::FORM_UPDATE) {
                    $requestId = Yii::$app->session->get('REQUEST_ID');
                    $this->updateRequest($requestId,$form);
                } else {
                    $this->createRequest($form);
                }
                $message = 'Форма заявки успешно сохранена';
                $this->getMessage($message);
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            $message = 'Произошла ошибка при сохранении формы заявки';            
            $this->getErrorMessage($message);
        }
        return [
            'exhibitionId' => Yii::$app->params['activeExhibition']
        ];
    }
    
    private function createRequest(StandForm $form)
    {
       $this->requestStandService->create($form,Yii::$app->params['activeExhibition']); 
    }
    
    private function updateRequest(int $requestId, StandForm $form)
    {
        /** @var Request $request */
        $request = $this->requestRepository->get($requestId);
        $this->requestStandService->edit($request->requestForm->id, $form);   
    }
}
