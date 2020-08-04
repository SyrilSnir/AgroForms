<?php

namespace app\modules\manage\modules\member\controllers;

use app\core\repositories\readModels\User\UserReadRepository;
use app\models\ActiveRecord\Users\User;
use app\modules\manage\controllers\AccessRule\BaseMemberController;
use Yii;
/**
 * Description of ProfileController
 *
 * @author kotov
 */
class ProfileController extends BaseMemberController
{

    public function __construct(
            $id, 
            $module, 
            UserReadRepository $repository,
            $config = array())
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
    }
    public function actionUser()
    {
        /** @var User $user */
        $user = $this->findModel(Yii::$app->user->getIdentity()->getId());
        return $this->render('user-profile', [
            'profile' => $user,
        ]);
    }
    
    public function actionCompany()
    {
        /** @var User $user */
        $user = $this->findModel(Yii::$app->user->getIdentity()->getId());
        $company = $user->company;
        return $this->render('company-profile', [
            'profile' => $company,
        ]);
    }        
}
