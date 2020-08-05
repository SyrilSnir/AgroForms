<?php

namespace app\core\services\operations\Profile;

use app\models\ActiveRecord\Users\User;
use app\models\Forms\Manage\Users\MemberForm;

/**
 * Description of UserService
 *
 * @author kotov
 */
class UserService
{
    /**
     *
     * @var User
     */
    protected $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function edit(MemberForm $form)
    {
        $this->user->phone = $form->phone;
        $this->user->position = $form->position;
        $this->user->birthday = $form->birthday;
        
        $this->user->save();
    }
}
