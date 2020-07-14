<?php

namespace app\core\manage\Auth;

use app\core\repositories\readModels\User\UserReadRepository;
use app\models\ActiveRecord\Users\Profile\UserProfileInterface;
use app\models\ActiveRecord\Users\User;
use yii\base\Model;
use yii\web\IdentityInterface;

/**
 * Description of UserIdentity
 *
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property string $passwordHash
 * 
 * @author kotov
 */
class UserIdentity extends Model implements IdentityInterface
{
    /**
     *
     * @var User
     */
    protected $user;
    
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function getId()
    {
        return $this->user->id;
    }


    public function validateAuthKey($authKey): bool
    {
        return $this->user->auth_key = $authKey;
    }

    public function getLogin()
    {
        return $this->user->login;
    }

    public function getFio()
    {
        return $this->user->fio;
    }
    
    public function getPhone()
    {
        return $this->user->phone;
    }
    
    public function getEmail()
    {
        return $this->user->email;
    }
    
    public function getPasswordHash()
    {
        return $this->user->password_hash;
    }

    public static function findIdentity($id): ?IdentityInterface
    {
        $user = UserReadRepository::findById($id);
        return $user ? new self($user) : null;
    }    

    public static function findIdentityByAccessToken($token, $type = null): IdentityInterface
    {
        
    }      

    public function getUserType()
    {
        return $this->user->user_type_id;
    }
    
    public function getProfile(): UserProfileInterface
    {
        return $this->user->profile;
    }
}
