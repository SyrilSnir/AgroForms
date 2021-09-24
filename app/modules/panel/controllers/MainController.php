<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Requests\RequestStandReadRepository;
use app\core\repositories\readModels\User\UserReadRepository;
use app\modules\panel\controllers\AccessRule\BaseController;

/**
 * Description of MainController
 *
 * @author kotov
 */
class MainController extends BaseController
{    
    /**
     * 
     * @var UserReadRepository
     */
    private $userRepository;
    
    /**
     * 
     * @var RequestStandReadRepository
     */
    private $requestStandReadRepository;

    public function __construct(
            $id, 
            $module, 
            UserReadRepository $userRepository,
            RequestStandReadRepository $requestStandReadRepository,
            $config = []
            )
    {
        parent::__construct($id, $module, $config);
        $this->userRepository = $userRepository;
        $this->requestStandReadRepository = $requestStandReadRepository;
    }
    
    public function actionIndex()
    {
        return $this->render('index',[
            'membersCount' => $this->userRepository->getAllMembers()->getCount(),
            'standsCount' => $this->requestStandReadRepository->getActiveStands()->getCount()
        ]);
    }
}
