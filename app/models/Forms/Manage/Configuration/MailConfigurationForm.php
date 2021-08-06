<?php

namespace app\models\Forms\Manage\Configuration;

use Yii;
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
            'smtpServer' => Yii::t('app', 'Mail server'),
            'smtpPort' => Yii::t('app', 'SMTP port'),
            'tls' => Yii::t('app', 'Use secure connection (TLS)'),
            'userName' => Yii::t('app/user', 'Username'),
            'password' => Yii::t('app/user', 'Password'),
            'senderName' => Yii::t('app', 'Sender name'),
            'senderEmail' => Yii::t('app', 'Sender email address'),
        ];
    }
}
