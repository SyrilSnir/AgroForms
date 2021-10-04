<?php

namespace app\modules\panel\controllers;

use app\core\manage\Auth\UserIdentity;
use app\core\services\Auth\AuthService;
use app\models\Forms\User\Manage\LoginForm;
use DomainException;
use yii\base\Exception;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Description of AuthController
 *
 * @author kotov
 */
class AuthController extends Controller
{
    /**
     *
     * @var AuthService
     */
    protected $authService;

    /**
     *
     * @var LoginForm
     */
    protected $loginForm;
    
    public function __construct(
            $id, 
            $module,
            AuthService $authService, 
            LoginForm $form,
            $config = array())
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
        $this->loginForm = $form;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new Exception('Вы уже авторизованы в системе');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ]
            ]
        ];
    }
    
    public function actionLogin()
    {
        $this->layout = 'main-login';
        if ($this->loginForm->load(Yii::$app->request->post()) &&
                $this->loginForm->validate()) {
            try {
                $user = $this->authService->auth($this->loginForm);
                Yii::$app->user->login(new UserIdentity($user));
              //  if (Yii::$app->user->can('adminPanel')) {
                return $this->redirect(Url::to('/panel'));
         //       }
             //   Yii::$app->user->logout();
             //   throw new DomainException('Недостаточно прав для входа в административную часть сайта');
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage()); 
            }
        }
        return $this->render('login',[
           'model' => $this->loginForm, 
        ]);
    }
}
