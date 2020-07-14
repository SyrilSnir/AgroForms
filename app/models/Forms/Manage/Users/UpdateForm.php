<?php

namespace app\models\Forms\Manage\Users;

/**
 * Description of UpdateForm
 *
 * @author kotov
 */
class UpdateForm extends UserManageForm
{
//    
    public function __construct(User $user = null, $config = array())
    {
        if ($user) {
            $this->fio = $user->fio;
            $this->phone = $user->phone;
            $this->birthday = $user->birthday;
        }
        parent::__construct($config);
    }
}
