<?php

namespace app\modules\panel\modules\member\controllers;

use app\core\manage\Auth\UserIdentity;
use app\core\repositories\readModels\Documents\DocumentReadRepository;
use app\core\services\operations\Documents\DocumentService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Document\Documents;
use app\models\Forms\Manage\Document\MemberDocumentForm;
use app\models\SearchModels\Documents\MemberDocumentSearch;
use app\modules\panel\controllers\AccessRule\BaseMemberController;
use DomainException;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * Description of DocumentsController
 *
 * @property MemberDocumentSearch $searchModel
 * @author kotov
 */
class DocumentsController extends BaseMemberController
{
    /**
     *
     * @var DocumentService
     */
    protected $service;
    
    use GridViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            DocumentReadRepository $repository,
            MemberDocumentSearch $searchModel,
            DocumentService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->searchModel = $searchModel;
        $this->service = $service;
    } 
    
    public function actionIndex($exhibitionId) 
    {
        Url::remember();
        /** @var UserIdentity $user */
        $user = Yii::$app->user->getIdentity();
        $dataProvider = $this->getDataProvider($exhibitionId,$user->getCompany()->id);
        $pageDataProvider = $this->configurePagination($dataProvider);
        return $this->render('index',[            
            'searchModel' => $this->searchModel,
            'dataProvider' => $pageDataProvider->getDataProvider(),
            'rowsCountForm' => $pageDataProvider->getRowsCountForm(),
            'pagination' => $this->showPagination,
            'exhibitionId' => $exhibitionId
        ]);
    }     
    
    public function actionCreate($exhibitionId)
    {
        /** @var UserIdentity $userIdentity */
        $userIdentity = Yii::$app->user->getIdentity();
        $companyId = $userIdentity->getCompany()->id;
        $form = new MemberDocumentForm($companyId, $exhibitionId);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $post = $this->service->create($form);
                return $this->redirect(['view', 'id' => $post->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    } 
    
    public function actionUpdate($id)
    {
        /** @var Documents $model */
        /** @var UserIdentity $userIdentity */
        $userIdentity = Yii::$app->user->getIdentity();
        $companyId = $userIdentity->getCompany()->id;        
        $model = $this->findModel($id);
        $form = new MemberDocumentForm($companyId, $model->exhibition_id, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
    
    protected function getDataProvider($exhibitionId, $companyId): ActiveDataProvider
    {
        return $this->searchModel->searchForExhibition($exhibitionId, $companyId);
    }
}
