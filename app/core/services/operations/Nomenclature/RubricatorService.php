<?php

namespace app\core\services\operations\Nomenclature;

use app\core\repositories\manage\Nomenclature\RubricatorRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of RubricatorService
 *
 * @author kotov
 */
class RubricatorService implements DataManqageInterface
{
    /**
     * 
     * @var RubricatorRepository
     */
    protected $rubricators;
    
    public function __construct(RubricatorRepository $rubricators)
    {
        $this->rubricators = $rubricators;
    }

    public function create(ManageForm $form): ActiveRecord
    {
        
    }

    public function edit(int $id, ManageForm $form): void
    {
        /** @var Rubricator $rubricator */
        $rubricator = $this->rubricators->get($id);
        $rubricator->edit($form);
        $this->rubricators->save($rubricator);          
    }

    public function remove(int $id): void
    {
        
    }

}
