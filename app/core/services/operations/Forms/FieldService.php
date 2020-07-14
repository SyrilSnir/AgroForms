<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FieldRepository;
use app\models\Forms\Manage\Forms\FieldForm;
use app\models\ActiveRecord\Forms\Field;
use function GuzzleHttp\json_encode;

/**
 * Description of FieldService
 *
 * @author kotov
 */
class FieldService
{
    /**
     *
     * @var FieldRepository
     */
    protected $fieldRepository;
    
    public function __construct(FieldRepository $fieldRepository)
    {
        $this->fieldRepository = $fieldRepository;
    }
    
    public function create(FieldForm $form)
    {
        $parameters = json_encode($form->parameters);
        
        $field = Field::create(
                $form->name, 
                $form->description, 
                $form->nameEng, 
                $form->descriptionEng, 
                $form->formId, 
                $form->elementTypeId, 
                $form->fieldGroupId,
                $form->order,
                $form->defaultValue,
                $parameters
                );
        $this->fieldRepository->save($field);
        return $field;
        
    }
    
    public function edit($id, FieldForm $form)
    {
        /** @var Field $field */
        $parameters = json_encode($form->parameters);
        $field = $this->fieldRepository->get($id);
        $field->edit(                
                $form->name, 
                $form->description, 
                $form->nameEng, 
                $form->descriptionEng, 
                $form->formId, 
                $form->elementTypeId, 
                $form->fieldGroupId,
                $form->order,
                $form->defaultValue,
                $parameters
                );
         $this->fieldRepository->save($field);
        return $field;       
    }

    
    
}
