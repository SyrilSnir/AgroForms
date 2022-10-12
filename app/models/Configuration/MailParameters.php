<?php

namespace app\models\Configuration;

/**
 * Description of SmtpParameters
 *
 * @author kotov
 */
class MailParameters extends \yii\base\Model
{
    /** @var string Имя сервера исходящей почты */
    public $smtpServer;
    /** @var string Порт */
    public $smtpPort;
    /** @var string Имя пользователя */
    public $userName;
    /**  @var bool Защищенное TLS соединение    */
    public $tls = false;
    /** @var string Пароль */
    public $password;
    
    public $senderName;
    
    public $senderEmail;


/**
 * 
 * @param string $smtpServer
 * @param int $smtpPort
 * @param string $smtpUserName
 * @param string $smtpPassword
 * @param string $senderEmail
 * @param string $senderName
 * @param string $tls
 * @return \self
 */
    public static function create(
            string $smtpServer,
            int $smtpPort,
            string $smtpUserName,
            string $smtpPassword,
            string $senderEmail,
            string $senderName = '',
            bool $tls = false
            ):self
    {
        $params = new self();
        $params->smtpServer = $smtpServer;
        $params->smtpPort = $smtpPort;
        $params->userName = $smtpUserName;
        $params->password = $smtpPassword;
        $params->senderEmail = $senderEmail;
        $params->senderName = $senderName;
        $params->tls = $tls;
        return $params;
    }            
}
