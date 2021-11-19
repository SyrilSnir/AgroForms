<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\modules\manager\controllers;

use app\core\repositories\readModels\User\UserReadRepository;
use app\core\services\operations\Users\UserService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Users\MemberForm;
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
    
    use GridViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            UserReadRepository $repository,
            UserService $userService,
            MemberSearch $searchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $userService;
        $this->searchModel = $searchModel;  
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
}
