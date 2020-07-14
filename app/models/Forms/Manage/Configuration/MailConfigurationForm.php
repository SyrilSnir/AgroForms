<?php

namespace app\models\Forms\Manage\Configuration;

use yii\base\Model;



/**
 * Description of SmtpConfigurationForm
 *
 * @author kotov
 */
class MailConfigurationForm extends Model implements ConfigurationFormInterface
{
    /**
     *
     * @var string
     */
    public $smtpServer;
    
    /**
     *
     * @var int
     */
    public $smtpPort;
    /**
     *
     * @var string
     */
    public $userName;
    
    /**
     *
     * @var string
     */
    public $password;
    /**
     *
     * @var bool
     */
    public $tls;
    
    /**
     *
     * @var string
     */
    public $senderName;
    
    /**
     *
     * @var null|string
     */
    public $senderEmail;
    
    
    public function rules(): array
    {
        return [
            [['smtpServer', 'smtpPort', 'userName', 'password','senderEmail'], 'required'],
            [['smtpPort'],'integer'],
            [['senderName'],'safe'],
            [['tls'],'boolean']
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'smtpServer' => 'Сервер исходящей почты',
            'smtpPort' => 'Порт SMTP',
            'tls' => 'Использовать защищенное соединение (TLS)',
            'userName' => 'Имя пользователя',
            'password' => 'Пароль подключения',
            'senderName' => 'Имя отправителя',
            'senderEmail' => 'Адрес электронной почты отправителя',
        ];
    }
}
