<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Nomenclature\EquipmentPriceReadRepository;
use app\core\repositories\readModels\Nomenclature\EquipmentReadRepository;
use app\core\services\operations\Nomenclature\EquipmentPriceService;
use app\models\ActiveRecord\Nomenclature\Equipment;
use app\models\Forms\Nomenclature\EquipmentPricesForm;
use app\modules\panel\controllers\BaseAdminController;
use DomainException;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Description of EquipmentPriceController
 *
 * @author kotov
 */
class EquipmentPriceController extends BaseAdminController
{
    /**
     * 
     * @var EquipmentPriceService
     */
    protected $service;    
    /**
     *
     * @var EquipmentPriceReadRepository
     */
    protected $readRepository;  
    
    /**
     * 
     * @var EquipmentPricesForm
     */
    protected $form;


    /**
     *
     * @var EquipmentReadRepository
     */
    protected $equipmentReadRepository; 
    
    public function __construct(
            $id, 
            $module, 
            EquipmentPriceReadRepository $readRepository,
            EquipmentReadRepository $equipmentReadRepository,
            EquipmentPriceService $service,
            $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->readRepository = $readRepository;
        $this->equipmentReadRepository = $equipmentReadRepository;
    }
    
    /**
     * 
     * @param integer $equipmentId
     */
    public function actionCreate($equipmentId) 
    {
        /** @var Equipment $equipment */
        $equipment = $this->equipmentReadRepository->findById($equipmentId);
        $form = new EquipmentPricesForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(Url::previous());
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $this->form->equipmentId = $equipment->id;
        return $this->render('create', [
            'model' => $form,
            'isUpdate' => false
        ]);                
    }
    
    /**
     * 
     * @param integer $equipmentId
     */
    public function actionUpdate($exhibition_id, $equipment_id) 
    {
        /** @var EquipmentPrices $equipment */
        $equipment = $this->findModel($exhibition_id, $equipment_id);        
        $form = new EquipmentPricesForm($equipment);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($equipment,$form);
                return $this->redirect(Url::previous());
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        //$this->form->equipmentId = $equipment-;
        return $this->render('update', [
            'model' => $form,
            'isUpdate' => true,
        ]);                
    }    
    
    /**
     * 
     * @param int $exhibitionId
     * @param int $equipmentId
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel(int $exhibitionId,int $equipmentId): ActiveRecord
    {
        if (($model = $this->readRepository->findByIds($exhibitionId, $equipmentId)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }    
    
}
