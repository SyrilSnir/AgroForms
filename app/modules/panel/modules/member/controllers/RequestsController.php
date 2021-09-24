<?php

namespace app\modules\panel\modules\member\controllers;

use app\core\repositories\manage\Forms\FormRepository;
use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\operations\Requests\RequestService;
use app\core\services\operations\View\Requests\RequestViewFactory;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\Requests\ApplicationSearch;
use app\models\SearchModels\Requests\RequestStandSearch;
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
     * @var RequestStandSearch
     */
    protected $standSearch;

    /**
     * 
     * @var ApplicationSearch
     */
    protected $applicationSearch;
            
    /**
     *
     * @var FormRepository
     */
    protected $formsRepository;
    
    public function __construct(
            $id, 
            $module, 
            RequestReadRepository $repository,
            RequestService $requestService,
            RequestStandSearch $standSearch,
            FormRepository $formRepository,            
            ApplicationSearch $applicationSearch,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $requestService;
        $this->standSearch = $standSearch;
        $this->applicationSearch = $applicationSearch;
        $this->formsRepository = $formRepository;
    }

    public function actionIndex($id)
    {
        Url::remember();

        $standDataProvider = $this->standSearch->searchForUser(
                Yii::$app->user->id,
                $id,
                Yii::$app->request->queryParams
                );
        $applicationDataProvider = $this->applicationSearch->searchForUser(
                Yii::$app->user->id,
                $id,
                Yii::$app->request->queryParams
                );        
        $isActive = (Yii::$app->params['activeExhibition'] == $id);
        return $this->render('index',[            
            'standSearchModel' => $this->standSearch,
            'standDataProvider' => $standDataProvider,
            'applicationSearchModel' => $this->applicationSearch,
            'applicationDataProvider' => $applicationDataProvider,            
            'isExhibitionActive' => $isActive
        ]);
    }
    public function actionCreate(int $id) 
    {
        /** @var Form $form */
        $form = $this->formsRepository->get($id);  
        $user = Yii::$app->user->getIdentity();    
        Yii::$app->session->set('FORM_CHANGE_TYPE', Request::FORM_CREATE);
        Yii::$app->session->remove('REQUEST_ID'); 
        return $this->render('create', [
            'form' => $form,
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
        if($request->status !== BaseRequest::STATUS_DRAFT) {
            throw new DomainException(t('This application is not available for editing','exception'));
        }
        Yii::$app->session->set('FORM_CHANGE_TYPE', Request::FORM_UPDATE);
        Yii::$app->session->set('REQUEST_ID', $request->id);        
        $user = Yii::$app->user->getIdentity();        
        return $this->render('update', [
            'request' => $request,
            //'formId' => 
            'user' => $user,
        ]);
            
    //    return $this->redirect(Url::to(['/panel/member/forms/load', 'id' => $requestForm->id, 'requestId' => $request->id]));
    }
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {        
        /** @var Request $model */
        $model = $this->findModel($id);
        $requestForm = $model->requestForm;
        $viewService = RequestViewFactory::getViewService($model);
        $dopAttributes = $viewService->getFieldAttributes($requestForm);

        return $this->render('view', [
            'model' => $model,
            'dopAttributes' => $dopAttributes
        ]);
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
}
