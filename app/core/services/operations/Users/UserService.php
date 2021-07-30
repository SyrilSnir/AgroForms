<?php

namespace app\core\services\operations\Users;

use app\core\manage\Auth\RoleManager;
use app\core\repositories\manage\Users\Profile\MemberProfileRepository;
use app\core\repositories\manage\Users\UserRepository;
use app\core\repositories\readModels\User\Profile\MemberProfileReadRepository;
use app\models\ActiveRecord\Users\Profile\MemberProfile;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Manage\Users\AdminForm;
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
     * @var MemberProfileRepository
     */
    protected $memberProfiles;
    
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
        $this->memberProfiles = $memberProfileRepository;
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
        switch ($user->user_type_id) {
            case UserType::ROOT_USER_ID:
                $this->roleManager->setRole(UserType::ROOT_USER_TYPE, $user->id);                  
            break;
            case UserType::MEMBER_USER_ID:
                $this->roleManager->setRole(UserType::MEMBER_USER_TYPE, $user->id);              
            break;
      }
        $this->users->save($user);        
    }
    
    public function remove($id)
    {
        /** @var User $user */
        $user = $this->users->get($id);
        $user->deleteUser();
        $this->users->save($user); 
    }
    
    
}
