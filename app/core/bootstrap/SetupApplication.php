<?php

namespace app\core\bootstrap;

use app\core\helpers\Data\ConfigurationHelper;
use app\core\manage\Auth\Rbac;
use app\core\manage\Auth\RoleManager;
use app\core\manage\Configuration\ConfigurationManager;
use app\core\repositories\manage\Exhibition\ExhibitionRepository;
use app\core\services\Mail\MailService;
use app\core\services\operations\Exhibition\ExhibitionService;
use app\core\services\operations\Profile\CompanyService;
use app\core\services\operations\Profile\UserService;
use app\models\ActiveRecord\Configuration;
use app\models\ActiveRecord\Users\User;
use app\models\Configuration\MailParameters;
use app\models\Forms\Manage\Configuration\MailConfigurationForm;
use Swift_SmtpTransport;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Yii;
use yii\base\BootstrapInterface;
use yii\rest\Serializer;
use yii\swiftmailer\Mailer;
use yii\web\Application;
use yii\web\Cookie;


/**
 * Description of SetupApplication
 *
 * @author kotov
 */
class SetupApplication implements BootstrapInterface
{
    public function bootstrap($app)
    {
        /** @var Application $app */
        $container = Yii::$container;
        
        $container->set(ExhibitionService::class, function ($container, $params, $args){
            $repository = new ExhibitionRepository();
            $cache = Yii::$app->cache;
            return new ExhibitionService($repository,$cache);
        });
        $container->set(Serializer::class, function ($container, $params, $args) {            
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            return new Serializer($normalizers, $encoders); 
        });
        $container->set(UserService::class, function ($container, $params, $args) {
            return new UserService(
            User::find()->where(['id' => Yii::$app->user->id])->one()
                    );
        } );
        $container->set(CompanyService::class, function ($container, $params, $args) {
            /** @var User $user */
            $user = User::find()->where(['id' => Yii::$app->user->id])->one();
            return new CompanyService($user->company);
        } );        
        $container->set(ConfigurationManager::class,function ($container, $params, $args) {
            return ConfigurationManager::getInstance();
        });
        
        $container->set(RoleManager::class, function($container, $params, $args){
            return new RoleManager(Yii::$app->authManager);
        });
        
        $container->setSingleton(MailService::class,function($container, $params, $args){
            $mailConfig = ConfigurationHelper::getConfig(Configuration::SMTP_SETTINGS_SECTION);
            $form = new MailConfigurationForm();
            $form->setAttributes($mailConfig);
            $smtp = true;
            if (!$form->validate()) {
                $mailConfig = Yii::$app->params['mailSettings'];
                $form->setAttributes($mailConfig);
                if (!$form->validate()) {
                    $smtp = false;
                }
            } 
            /** @var Mailer $mailer */
            $mailer = new Mailer(); 
            $mailer->setViewPath('@mail');
            if ($smtp) {
                $smtpParams = MailParameters::create(
                    $form->smtpServer, 
                    $form->smtpPort, 
                    $form->userName,
                    $form->password,
                    $form->senderEmail,
                    $form->senderName,
                    $form->tls ?? false
                    );
                $transport = (new Swift_SmtpTransport(
                    $smtpParams->smtpServer,
                    $smtpParams->smtpPort))
                        ->setUsername($smtpParams->userName)
                        ->setPassword($smtpParams->password);
                $mailer->setTransport($transport);
                return new MailService($mailer, $smtpParams->senderEmail,$smtpParams->senderName,$smtpParams);
            }
            $mailer->useFileTransport = true;
            return new MailService($mailer, 'test@test.ru','test');
        });
        if (Yii::$app->language == \app\models\Data\Languages::ENGLISH) {
            Yii::$app->formatter->locale = \app\models\Data\Languages::ENGLISH;
        }
    }

}
