<?php

namespace app\modules\panel\modules\member\controllers;

use app\core\helpers\Data\FormsHelper;
use app\core\repositories\manage\Forms\FormRepository;
use app\core\repositories\readModels\Logs\ApplicationRejectLogReadRepository;
use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\Log\ApplicationRejectLogService;
use app\core\services\operations\Requests\RequestService;
use app\core\traits\RequestViewTrait;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\Requests\ManagerRequestSearch;
use app\modules\panel\controllers\AccessRule\BaseMemberController;
use DomainException;
use Yii;
use yii\helpers\Url;

/**
 * Description of FormsController
 *
 * @author kotov
 */
class RequestsController extends BaseMemberController
{   
    /**
     *
     * @var RequestService
     */
    protected $service;
               
    /**
     *
     * @var FormRepository
     */
    protected $formsRepository;
    
    /**
     * 
     * @var ApplicationRejectLogReadRepository
     */
    protected $applicationRejectLogReadRepository;
    
    /**
     * 
     * @var ApplicationRejectLogService
     */
    protected  $applicationRejectLogService;    
    
    protected $searchModel;
    
    use RequestViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            RequestReadRepository $repository,
            RequestService $requestService,
            ManagerRequestSearch $searchModel,
            FormRepository $formRepository, 
            ApplicationRejectLogReadRepository $applicationRejectLogReadRepository,
            ApplicationRejectLogService $applicationRejectLogService,            
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $requestService;
        $this->formsRepository = $formRepository;
        $this->applicationRejectLogReadRepository = $applicationRejectLogReadRepository;
        $this->searchModel = $searchModel;
        $this->applicationRejectLogService = $applicationRejectLogService;        
    }

    public function actionIndex($exhibitionId,$contractId)
    {
        Url::remember();
        $applicationDataProvider = $this->searchModel->searchForUser(
                Yii::$app->user->id,
                $exhibitionId,
                $contractId,
                Yii::$app->request->queryParams
                );        
        $isActive = (Yii::$app->params['activeExhibition'] == $exhibitionId);
        
        return $this->render('index',[            
            'searchModel' => $this->searchModel,
            'dataProvider' => $applicationDataProvider,            
            'isExhibitionActive' => $isActive,
            'contractId' => $contractId,
            'availableForms' => FormsHelper::formsList($exhibitionId)
        ]);
    }
 
    public function actionCreate(int $formId, int $contractId) 
    {
        /** @var Form $form */
        $form = $this->formsRepository->get($formId);  
        $user = Yii::$app->user->getIdentity();    
        Yii::$app->session->set('FORM_CHANGE_TYPE', Request::FORM_CREATE);
        Yii::$app->session->remove('REQUEST_ID'); 
        return $this->render('create', [
            'form' => $form,
            'contractId' => $contractId,
            'user' => $user,
        ]);        
    }
    public function actionUpdate($id) 
    {
        /** @var Request $request */
        $request = $this->readRepository->findById($id);
        if (!$request) {
            throw new DomainException(t('The application with the specified number does not exist','exception'));
        }
        if($request->status !== BaseRequest::STATUS_DRAFT &&
                $request->status !== BaseRequest::STATUS_REJECTED) {
            throw new DomainException(t('This application is not available for editing','exception'));
        }
        Yii::$app->session->set('FORM_CHANGE_TYPE', Request::FORM_UPDATE);
        Yii::$app->session->set('REQUEST_ID', $request->id);        
        $user = Yii::$app->user->getIdentity();        
        return $this->render('update', [
            'request' => $request,
            'user' => $user,
        ]);
            
    //    return $this->redirect(Url::to(['/panel/member/forms/load', 'id' => $requestForm->id, 'requestId' => $request->id]));
    }
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::previous());
    }   

    public function actionGetRejectInfo(int $id) 
    {
        $this->viewPath = Yii::getAlias('@elements');
        $appicationRejectLogModel = $this->applicationRejectLogReadRepository->findActualForRequest($id);
        return $this->renderAjax('application-reject-log', [
             'model' => $appicationRejectLogModel
            ]);
    }    
}
