<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Nomenclature\EquipmentReadRepository;
use app\core\services\operations\Nomenclature\EquipmentService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Nomenclature\Equipment;
use app\models\Forms\Nomenclature\EquipmentForm;
use app\models\SearchModels\Nomenclature\EquipmentPricesSearch;
use app\models\SearchModels\Nomenclature\EquipmentSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;
use yii\helpers\Url;

/**
 * Description of EquipmentsController
 *
 * @author kotov
 */
class EquipmentsController extends BaseAdminController
{
    use GridViewTrait;
    /**
     *
     * @var EquipmentService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            EquipmentReadRepository $repository,
            EquipmentService $service,
            EquipmentSearch $searchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }
    
    public function actionCreate()
    {
        $form = new EquipmentForm();
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
            'isUpdate' => false,
        ]);
    }
    
    public function actionUpdate($id)    
    {        
        /** @var Equipment $model */
        $model = $this->findModel($id); 
        Url::remember();
        $pricesSearchModel = new EquipmentPricesSearch($model->id); 
        $form = new EquipmentForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
            'isUpdate' => true,
            'equipmentId' => $id,
            'pricesDataProvider' => $pricesSearchModel->search()
        ]);                        
    }
}
