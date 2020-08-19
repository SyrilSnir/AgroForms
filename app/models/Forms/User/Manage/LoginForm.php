<?php

namespace app\models\Forms\User\Manage;

use yii\base\Model;
/**
 * Description of LoginForm
 *
 * @author kotov
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    
    public function rules(): array
    {
        return [
            [['login','password'],'required'],            
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'login' => t('Login','user'),
            'password' => t('Password','user')
        ];
    }
}
