<?php

namespace app\core\manage\Auth;

use yii\rbac\ManagerInterface;

/**
 * Description of RoleManager
 *
 * @author kotov
 */
class RoleManager
{
    /**
     *
     * @var ManagerInterface
     */
    private $authManager;
    
    public function __construct(ManagerInterface $authManager)
    {
        $this->authManager = $authManager;
    }
    
    /**
     * 
     * @param int $userId
     * @param string $role
     * @return void
     */
    public function setRole(string $role, int $userId):void
    {
        $role = $this->authManager->getRole($role);
        $this->authManager->assign($role, $userId);
    }
    
    public function revokeRoles(int $userId)    
    {
        $this->authManager->revokeAll($userId);
    }

}
