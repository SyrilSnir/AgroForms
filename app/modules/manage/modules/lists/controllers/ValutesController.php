<?php

namespace app\modules\manage\modules\lists\controllers;

use app\core\repositories\readModels\Common\ValuteReadRepository;
use app\core\services\operations\Common\ValuteService;
use app\models\Forms\Common\ValuteForm;
use app\models\SearchModels\Common\ValuteSearch;
use app\modules\manage\controllers\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of ValutesController
 *
 * @author kotov
 */
class ValutesController extends BaseAdminController
{
    /**
     *
     * @var ValuteService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            ValuteReadRepository $repository,
            ValuteService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    } 
    
    public function actionIndex() 
    {
        $searchModel = new ValuteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 
    
    public function actionCreate()
    {
        $form = new ValuteForm();
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
        $form = new ValuteForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
