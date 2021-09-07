<?php

namespace app\modules\panel\modules\form\controllers;

use app\core\repositories\readModels\Forms\FormTypeReadRepository;
use app\core\services\operations\Forms\FormTypeService;
use app\models\ActiveRecord\Forms\FormType;
use app\models\Forms\Manage\Forms\FormTypeForm;
use app\models\SearchModels\Forms\FormTypeSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of FormTypesController
 *
 * @author kotov
 */
class FormTypesController extends BaseAdminController
{
    /**
     *
     * @var FormTypeService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            FormTypeReadRepository $repository,
            FormTypeService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  

    public function actionIndex() 
    {
        $searchModel = new FormTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     public function actionCreate()
    {
        $form = new FormTypeForm();        
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
        /** @var FormType $model */
        $model = $this->findModel($id);       
        $model->disableMultilang();
        $form = new FormTypeForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }   
}
