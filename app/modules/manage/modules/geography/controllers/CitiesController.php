<?php

namespace app\modules\manage\modules\geography\controllers;

use app\core\repositories\readModels\Geography\CityReadRepository;
use app\core\services\operations\Forms\ElementTypeService;
use app\core\services\operations\Geography\CityService;
use app\models\Forms\Geography\CityForm;
use app\models\Forms\RowsCountForm;
use app\models\SearchModels\Geography\CitySearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of CitiesController
 *
 * @author kotov
 */
class CitiesController extends BaseAdminController
{
        /**
     *
     * @var ElementTypeService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            CityReadRepository $repository,
            CityService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }
 
    public function actionIndex()
    {
        $searchModel = new CitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
        $rowsCountForm = new RowsCountForm();        
        if (!($rowsCountForm->load(Yii::$app->request->get()) && $rowsCountForm->validate())) {       
            $rowsCountForm->rowsCount = RowsCountForm::DEFAULT_ROWS_COUNT;
        }   
        $dataProvider->pagination = ['pageSize' => $rowsCountForm->rowsCount];       
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'rowsCountForm' => $rowsCountForm
        ]);   
    }
    
    public function actionCreate()
    {
        $form = new CityForm();
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
        $form = new CityForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }     
}
