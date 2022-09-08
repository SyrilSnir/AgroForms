<?php

namespace app\modules\panel\controllers;

use app\core\manage\Auth\Rbac;
use app\core\repositories\readModels\Companies\CompanyReadRepository;
use app\core\services\operations\Companies\CompanyService;
use app\core\services\operations\Users\UserService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Companies\Company;
use app\models\Forms\Manage\Companies\CompanyForm;
use app\models\Forms\Manage\Users\MemberForm;
use app\models\SearchModels\Companies\CompanySearch;
use DomainException;
use Yii;
use yii\helpers\Url;

/**
 * Description of CompaniesController
 *
 * @author kotov
 */
class CompaniesController extends ManageController
{
    public $roles = [
        Rbac::PERMISSION_MANAGER_MENU,
        Rbac::PERMISSION_ADMINISTRATOR_MENU,
        Rbac::PERMISSION_ORGANIZER_MENU
    ];

    use GridViewTrait;
    /**
     *
     * @var CompanyService
     */
    protected $service;  
    
    /**
     *
     * @var UserService
     */
    protected $userService;    
    
    public function __construct(
            $id, 
            $module, 
            CompanyReadRepository $repository,
            CompanyService $service,
            CompanySearch $searchModel,
            UserService $userService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->userService = $userService;
        $this->searchModel = $searchModel;
    }      
    
    public function actionCreate()
    {
        $form = new CompanyForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $post = $this->service->create($form);
                return $this->redirect(['view', 'id' => $post->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUnblock($id)
    {
        $this->service->unblock($id);
        return $this->redirect(Url::previous());
    }

    public function actionBlock($id)
    {
        $this->service->block($id);
        return $this->redirect(Url::previous());
    }
    
    public function actionAddMember($id)
    {
        /** @var Company $model */
        $model = $this->findModel($id);
        $redirectUrl = Yii::$app->user->can(Rbac::PERMISSION_ADMINISTRATOR_MENU) ? '/panel/users/view' : '/panel/manager/users/view';
        $form = new MemberForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->userService->createUser($form);
                return $this->redirect([$redirectUrl, 'id' => $user->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }        
        $form->company = $model->id;
        $form->fio = $model->contacts->manager_fio;
        $form->login = $model->contacts->manager_email;
        $form->email = $model->contacts->manager_email;
        $form->phone = $model->contacts->manager_phone;
       
        return $this->render('../users/create-member', [
            'model' => $form,
            'update' => false
        ]);   
        
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new CompanyForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
