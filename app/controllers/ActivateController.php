<?php

namespace app\controllers;

use app\core\repositories\readModels\User\UserReadRepository;
use app\core\services\Auth\UserActivateService;
use app\models\Forms\User\Manage\SetNewPasswordForm;
use Yii;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Description of ActivateController
 *
 * @author kotov
 */
class ActivateController extends Controller
{
    /**
     *
     * @var UserReadRepository
     */
    protected $usersRepository;
    /**
     *
     * @var UserActivateService
     */
    protected $activateService;


    public function __construct(
            $id, 
            $module, 
            UserReadRepository $repository,
            UserActivateService $activateService,
            $config = array()
            )
    {
        $this->usersRepository = $repository;
        $this->activateService = $activateService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex($token) 
    {
        $authKey = StringHelper::base64UrlDecode($token);
        $user = $this->usersRepository->findByAuthKey($authKey);
        if (!$user) {
            return  $authKey;
        }
        $setNewPasswordForm = new SetNewPasswordForm($authKey);
        return $this->render('index',
                [
                    'user' => $user,
                    'model' => $setNewPasswordForm
                ]);
    }
    
    public function actionSuccess()
    {
        $setNewPasswordForm = new SetNewPasswordForm();
        if ($setNewPasswordForm->load(Yii::$app->request->post()) &&
                $setNewPasswordForm->validate()) {
            $user = $this->activateService->activateUser($setNewPasswordForm);
            Yii::$app->session->setFlash(
                    'successActivate',
                    'Поздравляем! Ваша учетная запись успешно активирована. '
                    . 'Укажите <strong>'.$user->login.'</strong> в качестве логина');
            return $this->redirect(Url::toRoute('/panel/auth'));;
        }
        return 'error';
    }
}
