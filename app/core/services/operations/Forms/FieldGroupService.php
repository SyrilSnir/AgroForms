<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FieldGroupRepository;
use app\models\ActiveRecord\Forms\FieldGroup;
use app\models\Forms\Manage\Forms\FieldGroupForm;

/**
 * Description of FieldGroupService
 *
 * @author kotov
 */
class FieldGroupService
{
    /**
     *
     * @var FieldGroupRepository 
     */
    protected $fieldGroups;
    
    public function __construct(
            FieldGroupRepository $unitRepository
            )
    {
        $this->fieldGroups = $unitRepository;
    }
    
    public function create(FieldGroupForm $form) 
    {
        $fieldGroup = FieldGroup::create(
                $form->name, 
                $form->description,
                $form->nameEng,
                $form->descriptionEng,
                $form->order
                );
        $this->fieldGroups->save($fieldGroup);
        return $fieldGroup;
    }
    
    public function edit($id, FieldGroupForm $form)
    {
        /** @var FieldGroup $fieldGroup */
        $fieldGroup = $this->fieldGroups->get($id);
        $fieldGroup->edit(                
                $form->name, 
                $form->description,
                $form->nameEng,
                $form->descriptionEng,
                $form->order
                );
        $this->fieldGroups->save($fieldGroup);        
    }
    
    public function remove($id)
    {
        $fieldGroup = $this->fieldGroups->get($id);
        $this->fieldGroups->remove($fieldGroup);
    }
}
