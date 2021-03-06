<?php

namespace app\modules\manage\modules\geography\controllers;

use app\core\repositories\readModels\Geography\RegionReadRepository;
use app\core\services\operations\Forms\ElementTypeService;
use app\core\services\operations\Geography\RegionService;
use app\models\Forms\Geography\RegionForm;
use app\models\SearchModels\Geography\RegionSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of RegionsController
 *
 * @author kotov
 */
class RegionsController extends BaseAdminController
{
    
    /**
     *
     * @var ElementTypeService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            RegionReadRepository $repository,
            RegionService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }
     
    public function actionIndex()
    {
        $searchModel = new RegionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);   
    }

    public function actionCreate()
    {
        $form = new RegionForm();
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
}
