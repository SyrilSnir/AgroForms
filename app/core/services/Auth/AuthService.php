<?php

namespace app\core\services\Auth;

use app\core\repositories\readModels\User\UserReadRepository;
use app\models\ActiveRecord\Users\User;
use app\models\Forms\User\Manage\LoginForm;
use DomainException;
use yii\base\Model;
/**
 * Description of AuthService
 *
 * @author kotov
 */
class AuthService extends Model
{
    /**
     *
     * @var UserReadRepository
     */
    public $userReadRepository;
    
    public function __construct(UserReadRepository $repository, $config = array())
    {
        parent::__construct($config);
        $this->userReadRepository = $repository;
    }

    public function auth(LoginForm $loginForm):User
    {
        $user = $this->userReadRepository->findByLogin($loginForm->login);
        if (!$user || !$user->validatePassword($loginForm->password)) {
            throw new DomainException(t('The username or password you entered is incorrect','exception'));
        }
        if ($user->company->isBlocked()) {
            throw new DomainException(t('Your company has been disconnected from the system','exception'));            
        }
        return $user;
    }
}
