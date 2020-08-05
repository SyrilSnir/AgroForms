<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Manage\Users\Profiles\MemberProfileForm;
use yii\helpers\ArrayHelper;


/**
 * Description of MemberForm
 *
 * @author kotov
 */
class MemberForm extends UserManageForm
{
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
    
    public function __construct(User $user = null, $config = array())
    {     
        parent::__construct($config);
        if ($user) {
            $this->fio = $user->fio;
            $this->login = $user->login;
            $this->phone = $user->phone;
            $this->email = $user->email;
            $this->company = $user->company_id;
            $this->userType = UserType::MEMBER_USER_ID;
            $this->gender = $user->gender;
            $this->position = $user->position;
            $this->language = $user->language;
            $this->userId = $user->id;
        }
        
    }
    
    public function scenarios():array
    {
        return ArrayHelper::merge([
            self::SCENARIO_PROFILE_UPDATE => [
                'phone', 'birthday', 'gender', 'position'
            ]
        ], parent::scenarios());
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
            'language' => 'Язык',
            'description' => 'Description',
            'active' => 'Active',
            'gender' => 'Пол',
            'position' => \Yii::t('app/user','Position')
        ];
    }
}
