<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\User;
use yii\helpers\ArrayHelper;

/**
 * Description of UserForm
 *
 * @author kotov
 */
class CreateForm extends UserManageForm
{
    //public $birthday;
    public $password;
    public $passwordRepeat;    
        /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['password'],'required'],
            ['passwordRepeat', 'compare', 'compareAttribute'=>'password','message' => t('The passwords entered do not match')],            
        ];
        
        return ArrayHelper::merge(parent::rules(), $rules);
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'active' => 'Active',
            'genre' => 'Пол'
        ];
    }    
}
