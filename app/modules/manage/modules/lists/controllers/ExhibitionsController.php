<?php

namespace app\modules\manage\modules\lists\controllers;

use app\core\repositories\readModels\Exhibition\ExhibitionReadRepository;
use app\core\services\operations\Exhibition\ExhibitionService;
use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use app\models\SearchModels\Exhibition\ExhibitionSearch;
use app\modules\manage\controllers\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of ExhibitionsController
 *
 * @author kotov
 */
class ExhibitionsController extends BaseAdminController
{
    /**
     *
     * @var ExhibitionService 
     */
    protected $service;

    public function __construct(
            $id, 
            $module, 
            ExhibitionReadRepository $repository,
            ExhibitionService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }
    
    public function actionIndex() 
    {
        $searchModel = new ExhibitionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }  
    
    public function actionCreate()
    {
        $form = new ExhibitionForm();
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
        $form = new ExhibitionForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
