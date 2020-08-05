<?php

namespace app\modules\manage\modules\member\controllers;

use app\core\repositories\readModels\User\UserReadRepository;
use app\core\services\operations\Profile\CompanyService;
use app\core\services\operations\Profile\UserService;
use app\models\ActiveRecord\Users\User;
use app\models\Forms\Manage\Companies\CompanyForm;
use app\models\Forms\Manage\Users\MemberForm;
use app\modules\manage\controllers\AccessRule\BaseMemberController;
use Yii;
/**
 * Description of ProfileController
 *
 * @author kotov
 */
class ProfileController extends BaseMemberController
{

    /**
     *
     * @var UserService
     */
    protected $userService;
    
    /**
     *
     * @var CompanyService
     */
    protected $companyService;
    
    public function __construct(
            $id, 
            $module, 
            UserService $userService,
            CompanyService $companyService,
            UserReadRepository $repository,
            $config = array())
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->userService = $userService;
        $this->companyService = $companyService;
    }
    public function actionUser()
    {
        /** @var User $user */
        $user = $this->findModel(Yii::$app->user->getIdentity()->getId());
        return $this->render('user-profile-view', [
            'profile' => $user,
        ]);
    }
    
    public function actionUpdateUser()
    {
        /** @var User $user */
        $user = $this->findModel(Yii::$app->user->getIdentity()->getId());
        $userForm = new MemberForm($user);
        $userForm->setScenario(MemberForm::SCENARIO_PROFILE_UPDATE);
        if ($userForm->load(Yii::$app->request->post()) && $userForm->validate()) {
            $this->userService->edit($userForm);
            return $this->redirect(['user']);
        }
        
        return $this->render('user-profile-update', [
            'model' => $userForm,
        ]);        
        
    }

    public function actionUpdateCompany()
    {
        /** @var User $user */
        $user = $this->findModel(Yii::$app->user->getIdentity()->getId());
        $company = $user->company;
        $companyForm = new CompanyForm($company);
        $companyForm->setScenario(CompanyForm::SCENARIO_PROFILE_UPDATE);
        if ($companyForm->load(Yii::$app->request->post()) && $companyForm->validate()) {
            $this->companyService->edit($companyForm);
            return $this->redirect(['company']);
        }        
        
        return $this->render('company-profile-update', [
            'model' => $companyForm,
        ]);          
    }    


    public function actionCompany()
    {
        /** @var User $user */
        $user = $this->findModel(Yii::$app->user->getIdentity()->getId());
        $company = $user->company;
        return $this->render('company-profile-view', [
            'profile' => $company,
        ]);
    }        
}
