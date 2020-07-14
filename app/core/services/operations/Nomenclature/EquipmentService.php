<?php

namespace app\core\services\operations\Nomenclature;

use app\core\repositories\manage\Nomenclature\EquipmentRepository;
use app\models\ActiveRecord\Nomenclature\Equipment;
use app\models\Forms\Nomenclature\EquipmentForm;

/**
 * Description of EquipmentService
 *
 * @author kotov
 */
class EquipmentService
{
    /**
     *
     * @var EquipmentRepository 
     */
    protected $equipments;
    
    public function __construct(
            EquipmentRepository $equipmentRepository
            )
    {
        $this->equipments = $equipmentRepository;
    }
    
    public function create(EquipmentForm $form) 
    {
        $equipment = Equipment::create(
                $form->name, 
                $form->groupId,
                $form->unitId,
                $form->price,
                $form->description,
                $form->code,
                $form->nameEng,
                $form->descriptionEng                
                );
        $this->equipments->save($equipment);
        return $equipment;
    }
    
    public function edit($id ,EquipmentForm $form) 
    {
        /** @var Equipment $equipment */
        $equipment = $this->equipments->get($id);
        $equipment->edit(
                $form->name, 
                $form->groupId,
                $form->unitId,
                $form->price,
                $form->description,
                $form->code,
                $form->nameEng,
                $form->descriptionEng                
                );
        $this->equipments->save($equipment);
    }
    
    public function remove ($id) 
    {        
        /* @var $equipment Equipment */
         $equipment = $this->equipments->get($id);
         $this->equipments->remove($equipment);
    } 
}
