<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\User\UserReadRepository;
use app\core\services\Auth\UserActivateService;
use app\core\services\operations\Users\UserService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Manage\Users\AdminForm;
use app\models\Forms\Manage\Users\MemberForm;
use app\models\Forms\Manage\Users\UserManageForm;
use app\models\Forms\User\Manage\ActivateForm;
use app\models\SearchModels\Users\TrashUserSearch;
use app\models\SearchModels\Users\UserSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;
use yii\helpers\Url;

/**
 * Description of UsersController
 *
 * @author kotov
 */
class UsersController extends BaseAdminController
{
    use GridViewTrait;
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
    
    /**
     * 
     * @var TrashUserSearch
     */
    protected $trashSearch;
    
    public function __construct(
            $id, 
            $module, 
            UserReadRepository $repository,
            UserService $userService,
            UserActivateService $activateService,
            UserSearch $searchModel,
            TrashUserSearch $trashSearchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $userService;
        $this->activateService = $activateService;
        $this->searchModel = $searchModel;
        $this->trashSearch = $trashSearchModel;
    }      
    
    public function actionTrash()
    {
        Url::remember();
        $dataProvider =  $this->trashSearch->search(Yii::$app->request->queryParams);;
        $pageDataProvider = $this->configurePagination($dataProvider);
        return $this->render('trash',[            
            'searchModel' => $this->trashSearch,
            'dataProvider' => $pageDataProvider->getDataProvider(),
            'rowsCountForm' => $pageDataProvider->getRowsCountForm(),
            'pagination' => $this->showPagination
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
                $user = $this->service->createUser($form);
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
    
    public function actionUpdate($id) 
    {
        /** @var User $model */
        $model = $this->findModel($id);
        switch ($model->user_type_id) {
            case UserType::MEMBER_USER_ID: 
                $form = new MemberForm($model);
                $form->setScenario(MemberForm::SCENARIO_UPDATE);
                $view = 'create-member';
                if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                    $this->service->edit($id, $form);
                    return $this->redirect(['view', 'id' => $model->id]);                        
                }
                break;
            case UserType::ROOT_USER_ID:
            case UserType::ACCOUNTANT_USER_ID:
            case UserType::MANAGER_USER_ID:
                $form = new AdminForm($model);
                $form->setScenario(AdminForm::SCENARIO_UPDATE);                
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
            return $this->render('invite', [
                'eMail' => $activateForm->email,
            ]);
        }        
        return 'cancel';
    }
    
    public function actionRestore($id)
    {
        /** @var User $user */        
        $this->service->restore($id);
        return $this->redirect(Url::previous());
        
    }
    
    
}
