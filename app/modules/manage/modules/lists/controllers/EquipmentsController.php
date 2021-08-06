<?php

namespace app\modules\manage\modules\lists\controllers;

use app\core\repositories\readModels\Nomenclature\EquipmentReadRepository;
use app\core\services\operations\Nomenclature\EquipmentService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Nomenclature\EquipmentForm;
use app\models\SearchModels\Nomenclature\EquipmentSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

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
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new EquipmentForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }
}
