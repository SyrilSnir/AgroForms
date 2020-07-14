<?php

namespace app\core\services\Mail;

use app\models\Configuration\MailParameters;
use app\models\Configuration\SmtpParameters;
use yii\mail\MailerInterface;

/**
 * Description of MailService
 *
 * @author kotov
 */
class MailService
{
    /** @var MailerInterface объект, реализующий интерфейс MailerInterface,
     *  который используется для отправки почты */
    protected $mailer;
    /**
     *
     * @var MailParameters
     */
    protected $smtpParams;
    /** @var string Имя отправителя */
    protected $senderName;
    /** @var string Email отправителя */
    protected $senderEmail;
    
    /**
     * 
     * @param MailerInterface $mailer
     * @param string $senderEmail
     * @param string $senderName
     * @param SmtpParameters $smtpParams
     */
    public function __construct(
            MailerInterface $mailer, 
            string $senderEmail, 
            string $senderName = '', 
            MailParameters $smtpParams = null)
    {
        $this->mailer = $mailer;
        $this->smtpParams = $smtpParams;
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;  
    }
    
    public function compose($view, $params = [])
    {
        return $this->mailer->compose($view, $params)->setFrom($this->senderEmail);
    }  
}
