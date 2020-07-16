<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FieldRepository;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;
use app\models\Forms\Manage\Forms\FieldForm;
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
    
    /**
     *
     * @var FieldEnumService
     */
    protected $fieldEnumService;


    public function __construct(
            FieldRepository $fieldRepository,
            FieldEnumService $fieldEnumService
            )
    {
        $this->fieldRepository = $fieldRepository;
        $this->fieldEnumService = $fieldEnumService;
    }
    
    public function create(FieldForm $form): Field
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

    public function addEnums(Field $field,array $enumsList)
    {
        $this->fieldEnumService->clearForField($field->id);
        foreach ($enumsList as $enum) {
            $enumModel = FieldEnum::create(
                    $field->id, 
                    $enum['name'], 
                    $enum['value']
                    );
            $enumModel->save();            
        }
    }     
    
}
