<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FieldEnumRepository;
use app\models\ActiveRecord\Forms\FieldEnum;
use app\models\Forms\Manage\Forms\FieldEnumForm;

/**
 * Description of FieldEnumService
 *
 * @author kotov
 */
class FieldEnumService
{
    /**
     * 
     * @var FieldEnumRepository
     */
    protected $fieldEnumRepository;
    
    
    public function __construct(FieldEnumRepository $fieldEnumRepository)
    {
        $this->fieldEnumRepository = $fieldEnumRepository;
    }

    public function create(FieldEnumForm $form)
    {
        $model = FieldEnum::create($form->fieldId, $form->name, $form->value, $form->nameEng);
        $this->fieldEnumRepository->save($model);
        
    }
    public function clearForField(int $fieldId)
    {
        FieldEnum::deleteAll([
            'field_id' => $fieldId
        ]);
    }
    
    public function remove($id)
    {
        $fieldEnum = $this->fieldEnumRepository->get($id);
        $this->fieldEnumRepository->remove($fieldEnum);
    }    
}
