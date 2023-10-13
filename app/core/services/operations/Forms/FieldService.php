<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FieldRepository;
use app\core\repositories\manage\Forms\FormRepository;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\Form;
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

    /**
     *
     * @var  FormRepository
     */
    private $formRepository;    
    
    public function __construct(
            FieldRepository $fieldRepository,
            FieldEnumService $fieldEnumService,
            FormRepository $formRepository
            )
    {
        $this->fieldRepository = $fieldRepository;
        $this->fieldEnumService = $fieldEnumService;
        $this->formRepository = $formRepository;
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
                $form->showInRequest,
                $form->showInPdf,
                $form->toExport,
                $form->published,
                $form->labelId,
                $form->defaultValue,
                $parameters
                );
        $this->fieldRepository->save($field);
        $this->changeFormToDraft($field->form_id);
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
                $form->showInRequest,
                $form->showInPdf,
                $form->toExport,
                $form->published,
                $form->labelId,
                $form->defaultValue,
                $parameters
                );
        $this->fieldRepository->save($field);
        $this->changeFormToDraft($field->form_id);        
        return $field;       
    }

    public function addEnums(Field $field,array $enumsList)
    {
        $this->fieldEnumService->clearForField($field->id);
        foreach ($enumsList as $enum) {
            $enumModel = FieldEnum::create(
                    $field->id, 
                    $enum['name'], 
                    $enum['value'],
                    $enum['name_eng']
                    );
            $enumModel->save();            
        }
    }     
    public function remove($id)
    {
        /** @var Field $field */
        $field = $this->fieldRepository->get($id); 
        $this->fieldRepository->remove($field);
    }
    
    public function restore($id)
    {
        /** @var Field $field */
        $field = $this->fieldRepository->get($id); 
        $this->fieldRepository->restore($field);
    }

    private function changeFormToDraft(int $formId)
    {
        /** @var Form $form */
        $form = $this->formRepository->get($formId);
        $form->toDraft();
        $form->save();
    }
}