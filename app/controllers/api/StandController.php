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
    
    public function actionGetForm()
    {
        /** @var Form $stand */
        $userId = Yii::$app->user->getId();
        $stand = $this->formRepository->get(FormType::SPECIAL_STAND_FORM);
        $standsList = StandsHelper::standsList();
        $baseConfiguration = [
          'title' => $stand->headerName,
          'stands' => $standsList,
          'userId' => $userId              
        ];
        $baseConfiguration['dict'] = [
            'imageInfo' => t('Approximate image of the stand','requests'),
            'standInfo' => [
                'space' => t('Space','requests'),  
                'length' => t('Length','requests'),  
                'width' => t('Width','requests'),
                'unit' => t('m','requests')
            ],
            'valute' => t($stand->valute->char_code, 'requests'),
            'fileAttach' => [
                'browse' => t('Browse'),
                'selectFile' => t('Select file'),
                'attachFile' => t('Attach file'),
            ],            
            'total' => [
              'totalMsg' => t('Total','requests'),
              'totalHead' => t('Total amount payable','requests'),
            ],            
            'standSize' => t('Required stand size','requests'),
            'standLayout' => t('Stand layout','requests'),
            'frize' => [
                'frizeName' => t('Fascia name','requests'),
                'symbol'  => t('symb.','requests'),
                'name' => t('Name','requests'),
            ],
            'standPlan' => [
                'header' => t('Stand plan','requests'),
                'download' => t('Download a form \'Stand layout\'','requests'),
                'downloadInfo' => t('Attach the plan. Also you can download a form.','requests'),
                'attachInfo' => t('If you need more space for drawing, you can draw the plan on a separate sheet and attach it to this application.', 'requests')
            ],
            'buttons' => [
              'send' => t('Send application','requests'),
              'draft' => t('Save draft', 'requests'),
              'cancel' => t('Cancel', 'requests'),
            ],            
            
        ];        
        $formChangeType = Yii::$app->session->get('FORM_CHANGE_TYPE', Request::FORM_CREATE);
        if ($formChangeType === Request::FORM_UPDATE) {
            $requestId = Yii::$app->session->get('REQUEST_ID');
            /** @var Request $request */
            /** @var RequestStand $requestStand */
           $request = $this->requestRepository->getForUser($requestId, $userId);
           $requestStand = $request->requestForm;
           $baseConfiguration['update'] = true;
           $baseConfiguration['frizeName'] = $requestStand->frizeName;
           $baseConfiguration['width'] = $requestStand->width;
           $baseConfiguration['length'] = $requestStand->length;
           $baseConfiguration['square'] = $requestStand->square;
           $baseConfiguration['standId'] = $requestStand->stand_id;
           $baseConfiguration['fileName'] = $request->requestForm->file;   
        } else {
            $baseConfiguration['update'] = false;
        }
        
        $standConfiguration = ConfigurationHelper::getConfig(Configuration::STAND_SETTINGS_SECTION);
        
        return 
        ArrayHelper::merge($baseConfiguration, $standConfiguration);
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
