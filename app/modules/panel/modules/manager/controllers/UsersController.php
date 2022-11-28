<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\modules\manager\controllers;

use app\core\repositories\readModels\User\UserReadRepository;
use app\core\services\Auth\UserActivateService;
use app\core\services\operations\Users\UserService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Users\User;
use app\models\Forms\Manage\Users\MemberForm;
use app\models\Forms\User\Manage\ActivateForm;
use app\models\SearchModels\Users\MemberSearch;
use app\modules\panel\controllers\AccessRule\BaseManagerController;
use DomainException;
use Yii;

/**
 * Description of UsersController
 *
 * @author kotov
 */
class UsersController extends BaseManagerController
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
    
    use GridViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            UserReadRepository $repository,
            UserService $userService,
            UserActivateService $activateService,            
            MemberSearch $searchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $userService;
        $this->searchModel = $searchModel;  
        $this->activateService = $activateService;        
    }
    
    public function actionCreateMember()
    {
        $this->viewPath = Yii::getAlias('@modules') .
                DIRECTORY_SEPARATOR .'panel' .
                DIRECTORY_SEPARATOR .'views' . DIRECTORY_SEPARATOR . 'users';
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
}
