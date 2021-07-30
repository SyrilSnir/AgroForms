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
}
