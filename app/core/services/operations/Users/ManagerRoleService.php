<?php

namespace app\core\services\operations\Users;

use app\core\repositories\manage\Users\ManagerRoleRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Users\ManagerRoles;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of ManagerRoleService
 *
 * @author kotov
 */
class ManagerRoleService implements DataManqageInterface
{
    /**
     * 
     * @var ManagerRoleRepository
     */
    protected $roles;    
    
    public function __construct(ManagerRoleRepository $roles)
    {
        $this->roles = $roles;
    }

    public function create(ManageForm $form): ManagerRoles
    {
        $role = ManagerRoles::create($form);
        $this->roles->save($role);
        return $role;
    }

    public function edit(int $id, ManageForm $form): void
    {
        
    }

    public function remove(int $id): void
    {
        
    }
}
