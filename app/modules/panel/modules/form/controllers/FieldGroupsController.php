<?php

namespace app\modules\panel\modules\form\controllers;

use app\core\repositories\readModels\Forms\FieldGroupReadRepository;
use app\core\services\operations\Forms\FieldGroupService;
use app\models\ActiveRecord\Forms\FieldGroup;
use app\models\Forms\Manage\Forms\FieldGroupForm;
use app\models\SearchModels\Forms\FieldGroupSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of FieldGroupsController
 *
 * @author kotov
 */
class FieldGroupsController extends BaseAdminController
{
        /**
     *
     * @var FieldGroupService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            FieldGroupReadRepository $repository,
            FieldGroupService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    } 

    public function actionIndex() 
    {
        $searchModel = new FieldGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 

    public function actionCreate()
    {
        $form = new FieldGroupForm();
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
        /** @var FieldGroup $model */
        $model = $this->findModel($id);
        $model->disableMultilang();
        $form = new FieldGroupForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }      
}
