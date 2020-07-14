<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\ElementTypeRepository;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\Forms\Manage\Forms\ElementTypeForm;

/**
 * Description of ElementTypeService
 *
 * @author kotov
 */
class ElementTypeService
{
    /**
     *
     * @var ElementTypeRepository 
     */
    protected $elementTypes;
    
    public function __construct(
            ElementTypeRepository $repository
            )
    {
        $this->elementTypes = $repository;
    }
    
    public function create(ElementTypeForm $form) : ElementType
    {
        $model = ElementType::create($form->name, $form->description);
        $this->elementTypes->save($model);
        return $model;
    }

    public function edit($id, ElementTypeForm $form)
    {
        /** @var ElementType $model */
        $model = $this->elementTypes->get($id);
        $model->edit(
                $form->name,
                $form->description
                );
        $this->elementTypes->save($model); 
    }
}
