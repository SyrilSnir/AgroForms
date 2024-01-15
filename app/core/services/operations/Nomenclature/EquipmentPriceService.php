<?php

namespace app\core\services\operations\Nomenclature;

use app\core\repositories\manage\Nomenclature\EquipmentPricesRepository;
use app\models\ActiveRecord\Nomenclature\EquipmentPrices;
use app\models\Forms\Nomenclature\EquipmentPricesForm;

/**
 * Description of EquipmentPriceService
 *
 * @author kotov
 */
class EquipmentPriceService
{
    /**
     * 
     * @var EquipmentPricesRepository
     */
    protected $repository;
    
    public function __construct(EquipmentPricesRepository $repository)
    {
        $this->repository = $repository;
    }

    
    public function create(EquipmentPricesForm $form) 
    {
        $model = EquipmentPrices::create(
                $form->exhibitionId, 
                $form->equipmentId, 
                $form->price);
        $this->repository->save($model);
        return $model;
    }
    
    public function edit(EquipmentPrices $model , EquipmentPricesForm $form) 
    {        
        $model->edit($form);
        $this->repository->save($model);
    }    
}
