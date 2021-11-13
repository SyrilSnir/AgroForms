<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use yii\helpers\ArrayHelper;


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

    public function rules()
    {
        $rules = [
            [['login','email'],'required'],
            [
                ['login'],
                'unique',
                'targetClass'=> User::class,
                'filter' => [['<>', 'login', $this->login], 'deleted' => false],
                'message' => 'Пользователь с указанными данными уже зарегистрирован'
            ],
        ];     
        return ArrayHelper::merge(parent::rules(), $rules);
    }     
}
