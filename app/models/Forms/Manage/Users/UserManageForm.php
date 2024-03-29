<?php

namespace app\models\Forms\Manage\Users;

use app\core\traits\Lists\GetGenderListTrait;
use app\core\traits\Lists\GetLanguagesListTrait;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use DateTime;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Description of UserManageForm
 *
 * @author kotov
 */
class UserManageForm extends ActiveRecord
{        
    const SCENARIO_UPDATE = 'update';
    
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
   

    use GetGenderListTrait;
    use GetLanguagesListTrait;
    
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
            if ($user->birthday) {
                $this->birthday = DateTime::createFromFormat('Y-m-d',$user->birthday)->format('d.m.Y');
            }
        } else {
            $this->userType = UserType::MEMBER_USER_ID;
        }
        
    }  
    
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
        
    }
    
    public function rules()
    {
        return [
            [['login','email'],'required'],
            ['email','email'],
            [['position','login'],'string'],
            [['position'],'default' ,'value' => ''],
            [['userType','company', 'gender','language'],'integer'],
            [['company'], 'validateMemberUnique','on' => self::SCENARIO_DEFAULT],
            [['phone','fio'], 'string', 'max' => 255],
            [['birthday'], 'safe'],  
            [
                ['login','email'],
                'unique',
                'targetClass'=> User::class,
                'filter' => ['deleted' => false],
                'message' => t('The user with the specified data is already registered'),
                'on' => self::SCENARIO_DEFAULT
           ],
            [
                ['login','email'],
                'unique',
                'targetClass'=> User::class,
                'filter' => function(\yii\db\Query $query) {
                    return $query->andWhere(['deleted' => false])
                            ->andWhere(['!=', 'login', $this->login]);
                },//['deleted' => false, ['!=', 'login', $this->login]],
                'message' => t('The user with the specified data is already registered'),
                'on' => self::SCENARIO_UPDATE
           ],            
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
    
    public function validateMemberUnique($attribute, $params)
    {
        if ($this->userType != UserType::MEMBER_USER_ID) {
            return;
        }
        $member = User::findOne(['company_id' => $this->company, 'user_type_id' => UserType::MEMBER_USER_ID, 'deleted' => false]);
        if ($member) {
            $this->addError($attribute, t('An exhibitor for the specified company already exists'));
        }
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
