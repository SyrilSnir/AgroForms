<?php

namespace app\modules\panel\modules\form\controllers;

use app\core\repositories\readModels\Forms\ElementTypeReadRepository;
use app\core\services\operations\Forms\ElementTypeService;
use app\models\Forms\Manage\Forms\ElementTypeForm;
use app\models\SearchModels\Forms\ElementTypeSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of ElementTypesController
 *
 * @author kotov
 */
class ElementTypesController extends BaseAdminController
{
    /**
     *
     * @var ElementTypeService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            ElementTypeReadRepository $repository,
            ElementTypeService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }
 
    public function actionIndex() 
    {
        $searchModel = new ElementTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $form = new ElementTypeForm();
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
        $form = new ElementTypeForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
