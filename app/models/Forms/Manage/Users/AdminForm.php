<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;


/**
 * Description of AdminForm
 *
 * @author kotov
 */
class AdminForm extends UserManageForm
{
        
    public function __construct(User $user = null, $config = array())
    {     
        parent::__construct($user, $config);
        if (!$user) {
            $this->userType = UserType::ROOT_USER_ID;
        }        
    }  
}
