<?php

namespace app\modules\panel\modules\form\controllers;

use app\core\repositories\readModels\Forms\FieldTypeReadRepository;
use app\core\services\operations\Forms\FieldTypeService;
use app\models\Forms\Manage\Forms\FieldTypeForm;
use app\models\SearchModels\Forms\FieldTypeSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of FieldTypesController
 *
 * @author kotov
 */
class FieldTypesController extends BaseAdminController
{
    /**
     *
     * @var FieldTypeService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            FieldTypeReadRepository $repository,
            FieldTypeService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  

    public function actionIndex() 
    {
        $searchModel = new FieldTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 
 
    public function actionCreate()
    {
        $form = new FieldTypeForm();
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
        $model = $this->findModel($id);
        $form = new FieldTypeForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
