<?php

namespace app\modules\manage\modules\form\controllers;

use app\core\repositories\readModels\Forms\FormReadRepository;
use app\core\services\operations\Forms\FormService;
use app\models\Forms\Manage\Forms\FormsForm;
use app\models\SearchModels\Forms\FieldSearch;
use app\models\SearchModels\Forms\FormSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of FormsController
 *
 * @author kotov
 */
class FormsController extends BaseAdminController
{
    /**
     *
     * @var FormService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            FormReadRepository $repository,
            FormService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  

    public function actionIndex() 
    {
        $searchModel = new FormSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $formFieldsSearchModel = new FieldSearch();
        $formFieldsDataProvider = $formFieldsSearchModel->searchForForm($id , Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'formFieldsDataProvider' => $formFieldsDataProvider,
            'formFieldsModel' => $formFieldsSearchModel,
            
        ]);
    }
    
     public function actionCreate()
    {
        $form = new FormsForm();
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
        $form = new FormsForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
