<?php

namespace app\core\services\Auth;

use app\core\repositories\manage\Users\UserRepository;
use app\core\services\Mail\MailService;
use app\models\ActiveRecord\Users\User;
use app\models\Forms\User\Manage\SetNewPasswordForm;
use yii\helpers\StringHelper;
use yii\helpers\Url;


/**
 * Description of UserActivateService
 *
 * @author kotov
 */
class UserActivateService
{
    /**
     *
     * @var UserRepository
     */
    protected $users;
    
    /**
     *
     * @var MailService
     */
    protected $mailService;
    
    public function __construct(
            UserRepository $users,
            MailService $mailService
            )
    {
        $this->users = $users;
        $this->mailService = $mailService;
    }

    
    public function getActivateLink(User $user):string
    {
        if (!$user->auth_key) {
            $user->setAuthKey();
            $this->users->save($user);
        }
        $authKey = $user->auth_key;
        $token = StringHelper::base64UrlEncode( $user->auth_key );
        return Url::toRoute(['/activate', 'token' => $token], true);
    }
    
    /**
     * 
     * @param int $userId
     * @return bool
     */
    public function sendInvite(int $userId, string $email):bool
    {
        /** @var User $user */
        $user = $this->users->get($userId);
        $activateLink = $this->getActivateLink($user);
        
        return $this->sendInviteNotificationMail($user, $activateLink, $email);
    }

    public function activateUser(SetNewPasswordForm $form): User
    {
        $user = $this->users->getByAuthKey($form->token);
        $user->setPassword($form->password);
        $user->active = true;
        $this->users->save($user);
        
        return $user;
    }
    
    /**
     * 
     * @param User $user
     * @param string $link
     * @param string $email
     * @return bool
     */
    private function sendInviteNotificationMail(User $user, string $link, string $email):bool
    {
        $this->mailService->compose([
            'html' => 'invite-html',
            'text' => 'invite-text',
        ],[
            'siteUrl' => Url::toRoute(['/'],true),            
            'link' => $link,
            'email' => $user->email,
        ])->setTo($email)->setSubject('АГРОСАЛОН - вход на сервисный портал / AGROSALON - access to the Service-Portal')->send();        
        return true;
    }
    
}
