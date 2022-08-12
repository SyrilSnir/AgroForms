<?php

namespace app\core\services\operations\Users;

use app\core\manage\Auth\RoleManager;
use app\core\repositories\manage\Users\UserRepository;
use app\models\ActiveRecord\Users\Profile\MemberProfile;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Manage\Users\MemberForm;
use app\models\Forms\Manage\Users\UserManageForm;

/**
 * Description of UserService
 *
 * @author kotov
 */
class UserService
{
    /**
     *
     * @var UserRepository 
     */
    protected $users;    
    
    /**
     *
     * @var RoleManager
     */
    protected $roleManager;
    
    public function __construct(
            UserRepository $userRepository,
            RoleManager $roleManager
            )
    {
        $this->users = $userRepository;
        $this->roleManager = $roleManager;
    }   
    
    public function createUser(UserManageForm $form)
    {
        $user = User::create(
                $form->login,
                $form->userType, 
                $form->company, 
                $form->fio, 
                $form->email, 
                $form->phone, 
                $form->birthday, 
                $form->position,
                $form->gender, 
                $form->language
                );
        $this->users->save($user);  
        $this->roleManager->setRole(UserType::ROLES[$user->user_type_id], $user->id);
        return $user;
    }
    
    public function createMember(MemberForm $form)
    {
        $user = User::create(
                $form->login,
                UserType::MEMBER_USER_ID, 
                $form->company, 
                $form->fio, 
                $form->email, 
                $form->phone, 
                $form->birthday, 
                $form->position,
                $form->gender, 
                $form->language
                );
        $this->users->save($user);  
        $this->roleManager->setRole(UserType::ROLES[$user->user_type_id], $user->id);
        return $user;
    }    
    
    public function edit($id, UserManageForm $form)
    {
        /** @var User $user */
        /** @var MemberProfile $profile */
        $user = $this->users->get($id);

        $user->edit(
                $form->login,
                $form->userType, 
                $form->company, 
                $form->fio, 
                $form->email, 
                $form->phone, 
                $form->birthday, 
                $form->position,
                $form->gender,                 
                $form->language
                );
        $this->roleManager->revokeRoles($user->id);
        $this->roleManager->setRole(UserType::ROLES[$user->user_type_id], $user->id);        
        $this->users->save($user);        
    }
    
    public function remove($id)
    {
        /** @var User $user */
        $user = $this->users->get($id);
        $user->deleteUser();
        $this->users->save($user); 
    }
    
    public function restore($id)
    {
        /** @var User $user */        
        $user = $this->users->get($id);
        $user->restoreUser();
        $this->users->save($user);      
    }
    
    
}
