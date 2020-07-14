<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FormTypeRepository;
use app\models\ActiveRecord\Forms\FormType;
use app\models\Forms\Manage\Forms\FormTypeForm;

/**
 * Description of FormTypeService
 *
 * @author kotov
 */
class FormTypeService
{
    /**
     *
     * @var FormTypeRepository 
     */
    protected $formTypes;
    
    public function __construct(
            FormTypeRepository $unitRepository
            )
    {
        $this->formTypes = $unitRepository;
    }
    
    public function create(FormTypeForm $form) 
    {
        $formType = FormType::create($form->name, $form->description);
        $this->formTypes->save($formType);
        return $formType;
    }
    
    public function edit($id, FormTypeForm $form)
    {
        /** @var FormType $formType */
        $formType = $this->formTypes->get($id);
        $formType->edit($form->name, $form->description);
        $this->formTypes->save($formType);        
    }
}
