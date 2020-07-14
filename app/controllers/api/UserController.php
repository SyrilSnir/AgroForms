<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\repositories\readModels\User\UserReadRepository;
use app\core\services\Auth\UserActivateService;

/**
 * Description of UserController
 *
 * @author kotov
 */
class UserController extends JsonController
{
    /**
     *
     * @var UserActivateService
     */
    protected $activateService;
    
    /**
     *
     * @var UserReadRepository
     */
    protected $usersRepository;
    
    public function __construct(
            $id, 
            $module,
            UserActivateService $activateService,
            UserReadRepository $userReadRepository,
            $config = array()
            )
    {
        $this->activateService = $activateService;
        $this->usersRepository = $userReadRepository;
        parent::__construct($id, $module, $config);
        
    }

    

    public function actionGetActivateLink($id)
    {
        $user = $this->usersRepository->findById($id);
        if (!$user) {
            return ['error'];
        }
        $link = $this->activateService->getActivateLink($user);
        return [$link];
    }
}
