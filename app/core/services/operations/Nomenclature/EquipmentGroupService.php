<?php

namespace app\core\services\operations\Nomenclature;

use app\core\repositories\manage\Nomenclature\EquipmentGroupRepository;
use app\models\ActiveRecord\Nomenclature\EquipmentGroup;
use app\models\Forms\Nomenclature\EquipmentGroupForm;

/**
 * Description of CategoryService
 *
 * @author kotov
 */
class EquipmentGroupService
{
    /**
     *
     * @var EquipmentGroupRepository 
     */
    protected $equipmentGroups;
    
    public function __construct(
            EquipmentGroupRepository $equipmentGroupRepository
            )
    {
        $this->equipmentGroups = $equipmentGroupRepository;
    }
    
    public function create(EquipmentGroupForm $form) 
    {
        $equipmentGroup = EquipmentGroup::create(
                $form->name, 
                $form->description,
                $form->nameEng,
                $form->descriptionEng
                );
        $this->equipmentGroups->save($equipmentGroup);
        return $equipmentGroup;
    }
    
    public function edit($id ,EquipmentGroupForm $form) 
    {
        /** @var EquipmentGroup $equipmentGroup */
        $equipmentGroup = $this->equipmentGroups->get($id);
        $equipmentGroup->edit(
                $form->name, 
                $form->description,
                $form->nameEng,
                $form->descriptionEng
                );
        $this->equipmentGroups->save($equipmentGroup);
    }
    
    public function remove ($id) 
    {        
        /* @var $equipmentGroup EquipmentGroup */
         $equipmentGroup = $this->equipmentGroups->get($id);
         $this->equipmentGroups->remove($equipmentGroup);
    }    
}
