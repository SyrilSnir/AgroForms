<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Companies\Company;
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

    protected function internalForms(): array
    {
        
    }

}
