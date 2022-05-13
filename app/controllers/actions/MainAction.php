<?php

namespace app\controllers\actions;

use app\core\repositories\readModels\Requests\RequestStandReadRepository;
use app\core\repositories\readModels\User\UserReadRepository;
use yii\base\Action;

/**
 * Description of MainAction
 *
 * @author kotov
 */
class MainAction extends Action
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
            $controller, 
            UserReadRepository $userRepository,
            RequestStandReadRepository $requestStandReadRepository,
            $config = [])
    {
        $this->userRepository = $userRepository;
        $this->requestStandReadRepository = $requestStandReadRepository;          
        parent::__construct($id, $controller, $config);
    }
    public function run()
    {
        return $this->controller->render('index',[
            'membersCount' => $this->userRepository->getAllMembers()->getCount(),
            'standsCount' => $this->requestStandReadRepository->getActiveStands()->getCount()
        ]);
    }
}
