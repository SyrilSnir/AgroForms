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
        parent::__construct($config);
        if ($user) {
            $this->fio = $user->fio;
            $this->login = $user->login;
            $this->phone = $user->phone;
            $this->email = $user->email;
            $this->company = $user->company_id;
            $this->userType = UserType::ROOT_USER_ID;
            $this->genre = $user->genre;
            $this->userId = $user->id;
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
                'filter' => ['<>', 'id', $this->userId],
                'message' => 'Пользователь с указанными данными уже зарегистрирован'
            ],             
        ];     
        return ArrayHelper::merge(parent::rules(), $rules);
    } 
    
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'userType' => 'Тип пользователя',
            'company' => 'Компания',
            'fio' => 'ФИО',
            'email' => 'Email',
            'phone' => 'Номер телефона',
            'birthday' => 'Дата рождения',
            'gengre' => 'Пол',
            'language' => 'Язык',
            'description' => 'Description',
            'active' => 'Active',
            'genre' => 'Пол'
        ];
    }

        public function internalForms(): array
    {
        return ['member'];
    }
}
