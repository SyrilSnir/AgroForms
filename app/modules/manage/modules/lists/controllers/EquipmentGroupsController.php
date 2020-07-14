<?php

namespace app\modules\manage\modules\lists\controllers;

use app\core\repositories\readModels\Nomenclature\EquipmentGroupReadRepository;
use app\core\services\operations\Nomenclature\EquipmentGroupService;
use app\models\Forms\Nomenclature\EquipmentGroupForm;
use app\models\SearchModels\Nomenclature\EquipmentGroupSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of CategoriesController
 *
 * @author kotov
 */
class EquipmentGroupsController extends BaseAdminController
{
    /**
     *
     * @var EquipmentGroupService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            EquipmentGroupReadRepository $repository,
            EquipmentGroupService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  
    
    public function actionIndex() 
    {
        $searchModel = new EquipmentGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $form = new EquipmentGroupForm();
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
        $form = new EquipmentGroupForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    } 
}
