<?php

namespace app\modules\manage\controllers;

use app\core\repositories\readModels\User\UserReadRepository;
use app\core\services\Auth\UserActivateService;
use app\core\services\operations\Users\UserService;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Manage\Users\AdminForm;
use app\models\Forms\Manage\Users\MemberForm;
use app\models\Forms\Manage\Users\UserManageForm;
use app\models\Forms\RowsCountForm;
use app\models\Forms\User\Manage\ActivateForm;
use app\models\SearchModels\Users\UserSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of UsersController
 *
 * @author kotov
 */
class UsersController extends BaseAdminController
{
    
    /**
     *
     * @var UserService
     */
    protected $service;
    /**
     *
     * @var UserActivateService
     */
    protected $activateService;    
    
    public function __construct(
            $id, 
            $module, 
            UserReadRepository $repository,
            UserService $userService,
            UserActivateService $activateService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $userService;
        $this->activateService = $activateService;
  
    }  
    
    public function actionIndex() 
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        $rowsCountForm = new RowsCountForm();        
        if (!($rowsCountForm->load(Yii::$app->request->get()) && $rowsCountForm->validate())) {       
            $rowsCountForm->rowsCount = RowsCountForm::DEFAULT_ROWS_COUNT;
        }   
        $dataProvider->pagination = ['pageSize' => $rowsCountForm->rowsCount];
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'rowsCountForm' => $rowsCountForm
        ]);
    }
    
    public function actionCreateAdmin()
    {
        $form = new AdminForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->createAdmin($form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-admin', [
            'model' => $form,
            'update' => false
        ]);        
    }
    public function actionCreateUser() 
    {
        $form = new UserManageForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->createMember($form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'update' => false
        ]);        
        
    }
    public function actionCreateMember()
    {
        $form = new MemberForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->createMember($form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-member', [
            'model' => $form,
            'update' => false
        ]);
    } 
    
    public function actionUpdate($id) 
    {
        /** @var User $model */
        $model = $this->findModel($id);
        switch ($model->user_type_id) {
            case UserType::MEMBER_USER_ID: 
                $form = new MemberForm($model);
                $view = 'create-member';
                if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                    $this->service->edit($id, $form);
                    return $this->redirect(['view', 'id' => $model->id]);                        
                }
                break;
            case UserType::ROOT_USER_ID:
                $form = new AdminForm($model);
                $view = 'create-admin';                
                if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                    $this->service->edit($id, $form);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                break;
            default:
                return 'Будет позже';
                break;
        }
        
        return $this->render($view,[
            'model' => $form,
            'update' => true
                ]);
    }
    
    public function actionInvite($id)
    {
        /** @var User $user */
        $activateForm = new ActivateForm();
        $user = $this->readRepository->findById($id);
        //dump($user);
        if ($activateForm->load(Yii::$app->request->post()) && $activateForm->validate() && $user) {
            $this->activateService->sendInvite($user->id, $activateForm->email);
            return 'send';
        }        
        return 'cancel';
    }
    
    
}
