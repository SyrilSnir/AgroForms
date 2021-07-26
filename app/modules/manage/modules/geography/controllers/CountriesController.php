<?php

namespace app\modules\manage\modules\geography\controllers;

use app\core\repositories\readModels\Geography\CountryReadRepository;
use app\core\services\operations\Geography\CountryService;
use app\models\Forms\Geography\CountryForm;
use app\models\SearchModels\Geography\CountrySearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of CountriesController
 *
 * @author kotov
 */
class CountriesController extends BaseAdminController
{
    /**
     *
     * @var CountryService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            CountryReadRepository $repository,
            CountryService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  
    
    public function actionIndex() 
    {
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new CountryForm();
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
        $form = new CountryForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }      
}
