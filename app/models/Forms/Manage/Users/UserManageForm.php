<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Description of UserManageForm
 *
 * @author kotov
 */
class UserManageForm extends ActiveRecord
{
    public $fio;
    public $login;
    public $phone;
    public $birthday;
    public $email;
    public $userType;
    public $company;
    public $gender;
    public $position;
    public $language;
    public $userId;
   

    public function __construct(User $user = null, $config = array())
    {     
        parent::__construct($config);
        if ($user) {
            $this->fio = $user->fio;
            $this->login = $user->login;
            $this->phone = $user->phone;
            $this->email = $user->email;
            $this->company = $user->company_id;
            $this->position = $user->position;
            $this->userType = $user->user_type_id;
            $this->gender = $user->gender;
            $this->userId = $user->id;
            $this->birthday = $user->birthday;
        } else {
            $this->userType = UserType::MEMBER_USER_ID;
        }
        
    }    
    public function rules()
    {
        return [
            ['email','email'],
            [['position'],'string'],
            [['position'],'default' ,'value' => ''],
            [['userType','company', 'gender','language'],'integer'],
            [['phone','fio'], 'string', 'max' => 255],
            [['birthday'], 'safe'],
        ];
    }
    
    public function typeList()
    {
        return ArrayHelper::map(
                        UserType::find()->orderBy('name')->asArray()->all(), 
                        'id', 
                        'name');        
    }

    public function organizationList()
    {
        return ArrayHelper::map(
                        Company::find()->orderBy('name')->asArray()->all(), 
                        'id', 
                        'name');        
    }
    
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'login' => t('Login','user'),
            'userType' => t('User type', 'user'),
            'company' => t('Company','user'),
            'fio' => t('Full name','user'),
            'email' => t('Email','user'),
            'phone' => t('Phone number','user'),
            'birthday' => t('Birthday','user'),
            'language' => t('Language','user'),
            'description' => t('Description'),
            'active' => t('Status','user'),
            'gender' => t('Gender', 'user'),
            'position' => t('Position','user')
        ];
    }    
}
