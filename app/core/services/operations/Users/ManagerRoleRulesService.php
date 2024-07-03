<?php

namespace app\core\services\operations\Users;

use app\core\repositories\manage\Users\ManagerRoleRulesRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Users\ManagerRoleRules;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of ManagerRoleRulesService
 *
 * @author kotov
 */
class ManagerRoleRulesService implements DataManqageInterface
{
    /**
     * 
     * @var ManagerRoleRulesRepository
     */
    protected $repository;
    
    public function __construct(ManagerRoleRulesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ManageForm $form): ActiveRecord
    {
        $model = ManagerRoleRules::create($form);        
        $this->repository->save($model);
        return $model;
    }

    public function edit(int $id, ManageForm $form): void
    {
        /** @var ManagerRoleRules $model */
        $model = $this->repository->get($id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove(int $id): void
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}
