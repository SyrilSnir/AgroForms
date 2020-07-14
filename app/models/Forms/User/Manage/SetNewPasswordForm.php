<?php

namespace app\models\Forms\User\Manage;

use yii\base\Model;

/**
 * Description of SetNewPasswordForm
 *
 * @author kotov
 */
class SetNewPasswordForm extends Model
{
    public $password;
    public $passwordRepeat;
    public $token;


    public function __construct(string $token = null, $config = array())
    {
        if ($token) {
            $this->token = $token;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['token'], 'required'],
            [['password','passwordRepeat'],'required'],
            [['password','passwordRepeat'],'trim'],
            ['passwordRepeat','compare', 'compareAttribute'=>'password','message' => 'Введенные пароли не совпадают']
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'password' => 'Задайте пароль для учетной записи',
            'passwordRepeat' => 'Повторите пароль',
        ];
    }
}
