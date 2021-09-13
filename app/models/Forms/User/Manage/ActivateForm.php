<?php

namespace app\models\Forms\User\Manage;

use yii\base\Model;

/**
 * Description of ActivateForm
 *
 * @author kotov
 */
class ActivateForm extends Model
{
    public $email;
    
    /**
     * 
     * @param string $email
     * @param type $config
     */
    public function __construct(string $email = null,$config = array())
    {
        $this->email = $email;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['email'], 'required'],
            [['email'], 'email']
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'email' => t('Enter your email or leave the one specified during registration','user')
        ];
    }
}
