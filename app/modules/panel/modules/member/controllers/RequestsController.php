<?php

namespace app\modules\panel\modules\member\controllers;

use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\operations\Requests\RequestService;
use app\core\services\operations\View\Requests\RequestDynamicFormViewService;
use app\core\services\operations\View\Requests\RequestStandViewService;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestDynamicForm;
use app\models\SearchModels\Requests\RequestSearch;
use app\modules\panel\controllers\AccessRule\BaseMemberController;
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
     * @var RequestDynamicFormViewService
     */
    private $dynamicFormViewService;
    /**
     *
     * @var RequestStandViewService
     */
    private $standViewService;
    
    /**
     *
     * @var RequestService
     */
    protected $service;


    public function __construct(
            $id, 
            $module, 
            RequestReadRepository $repository,
            RequestDynamicFormViewService $requestDynamicFormViewService,
            RequestStandViewService $requestStandViewService,
            RequestService $requestService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->dynamicFormViewService = $requestDynamicFormViewService;
        $this->standViewService = $requestStandViewService;
        $this->service = $requestService;
    }

    public function actionIndex($id)
    {
        Url::remember();
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->searchForUser(
                Yii::$app->user->id,
                $id,
                Yii::$app->request->queryParams
                );
        $isActive = (Yii::$app->params['activeExhibition'] == $id);
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isExhibitionActive' => $isActive
        ]);
    }
    
    public function actionUpdate($id) 
    {
        /** @var Request $request */
        $request = $this->readRepository->findById($id);
        return $this->redirect(Url::to(['/panel/member/forms/load', 'id' => $request->form->id, 'requestId' => $request->id]));
    }
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {        
        /** @var Request $model */
        $dopAttributes = [];
        $model = $this->findModel($id);
        $requestForm = $model->requestForm;
        $form =  $model->form;
        switch ($form->form_type_id) {
            case FormType::SPECIAL_STAND_FORM:
                $dopAttributes = $this->standViewService->getFieldAttributes($requestForm);
                break;
            case FormType::DYNAMIC_INFORMATION_FORM:
            case FormType::DYNAMIC_ORDER_FORM:
            /** @var RequestDynamicForm $requestForm */
                $dopAttributes = $this->dynamicFormViewService->getFieldAttributes($requestForm);
            break; 
        }

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
