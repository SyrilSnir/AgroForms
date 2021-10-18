<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FormRepository;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;
use app\models\ActiveRecord\Forms\Form;
use app\models\Forms\Manage\Forms\CopyForm;
use app\models\Forms\Manage\Forms\FormsForm;

/**
 * Description of FormService
 *
 * @author kotov
 */
class FormService
{
    /**
     *
     * @var FormRepository
     */
    protected $forms;
    
    public function __construct(
            FormRepository $repository
            )
    {
        $this->forms = $repository;
        
    }
    
    public function create(FormsForm $form):Form
    {
        $model = Form::create($form);
        $this->forms->save($model);
        return $model;
    }
    
    public function edit($id, FormsForm $form)
    {
        /** @var Form $model */
        $model = $this->forms->get($id);
        $model->edit($form);
        $this->forms->save($model);  
    }
    
    public function publish(int $id)
    {
        /** @var Form $model */
        $model = $this->forms->get($id); 
        $model->publish();
        $this->forms->save($model);       
    }
    
    public function unpublish(int $id)
    {
        /** @var Form $model */
        $model = $this->forms->get($id);        
        $model->toDraft();
        $this->forms->save($model);        
    }  
    
    public function copy(CopyForm $form) :Form
    {
        /** @var Form $originalForm */        
        /** @var Field $field */        
        /** @var FieldEnum $fieldEnum */        
        $originalForm = $this->forms->get($form->formId);
        $formCopy = new Form();
        $formCopy->setAttributes($originalForm->attributes,false);
        $formCopy->isNewRecord = true;
        $formCopy->id = null;
        $formCopy->exhibition_id = $form->exhibitionId;
        $formCopy->status = Form::STATUS_DRAFT;
        $this->forms->save($formCopy);
        foreach ($originalForm->formFields as $field) {
            $fieldCopy = new Field();
            $fieldCopy->setAttributes($field->attributes,false);
            $fieldCopy->id = null;
            $fieldCopy->isNewRecord = true;
            $fieldCopy->form_id = $formCopy->id;
            $fieldCopy->save();
            if (in_array($field->element_type_id,ElementType::HAS_ENUM_ATTRIBUTES)) {
                foreach ($field->enums as $fieldEnum) {
                    $enumCopy = new FieldEnum();
                    $enumCopy->setAttributes($fieldEnum->attributes,false);
                    $enumCopy->id = null;
                    $enumCopy->isNewRecord = true;
                    $enumCopy->field_id = $fieldCopy->id;
                    $enumCopy->save();                                               
                }
                    
            }
        }
        return $formCopy;
    }
    
    
    
}
