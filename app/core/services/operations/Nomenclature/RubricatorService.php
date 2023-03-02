<?php

namespace app\core\services\operations\Nomenclature;

use app\core\repositories\manage\Nomenclature\RubricatorRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\Forms\Manage\ManageForm;
use app\models\Forms\Nomenclature\RubricatorForm;
use DomainException;
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
        /** @var RubricatorForm $form */
        /** @var Rubricator $parentNode */
        $parentNode = $this->rubricators->get($form->parentId);
        if (!$parentNode) {
            throw new DomainException('Не указан родительский раздел');
        }        
        $siblingsCount = count($parentNode->children(1)->asArray()->all());
        $rubricator = Rubricator::createAnyNode($form->name, $form->nameEng, $siblingsCount + 1);
        $rubricator->appendTo($parentNode);
        return $rubricator;
    }

    public function edit(int $id, ManageForm $form): void
    {
        /** @var Rubricator $rubricator */
        /** @var Rubricator $newParent */
        /** @var RubricatorForm $form */        
        $rubricator = $this->rubricators->get($id);
        $rubricator->edit($form);
        $this->rubricators->save($rubricator);
        $parentNode = $rubricator->parent;
        if ($parentNode && $parentNode->id != $form->parentId) {
            $newParent = $this->rubricators->get($form->parentId);
            $siblingsCount = count($newParent->directChildren()->asArray()->all());
            $rubricator->order = $siblingsCount + 1;
            $rubricator->appendTo($newParent);
            $parentNode->reindexDirectChildren();
        }
    }

    public function remove(int $id): void
    {
        /** @var Rubricator $rubricator */
        $rubricator = $this->rubricators->get($id);
        $this->rubricators->remove($rubricator);
    }

}
