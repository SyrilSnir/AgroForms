<?php

namespace app\commands\controllers;

use app\core\manage\Auth\Rbac;
use app\models\ActiveRecord\Users\UserType;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Управление ролями пользователей 
 *
 * @author kotov
 */
class RbacController extends Controller
{
    /**
     * Установка ролей
     */
    public function actionInit()
    {        
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        
        $admin = $auth->createRole(UserType::ROOT_USER_TYPE);
        $admin->description = 'Администратор';
        $auth->add($admin);
        
        $member = $auth->createRole(UserType::MEMBER_USER_TYPE);
        $member->description = 'Роль участника выставки';
        $auth->add($member);
        
        
        
        $adminMenu = $auth->createPermission(Rbac::PERMISSION_ADMINISTRATOR_MENU);
        $adminMenu->description ='Меню администратора';
        $auth->add($adminMenu);
        $auth->addChild($admin, $adminMenu);
        
        $memberMenu = $auth->createPermission(Rbac::PERMISSION_MEMBER_MENU);
        $memberMenu->description = 'Меню участника выставки';
        $auth->add($memberMenu);
        $auth->addChild($member, $memberMenu);
        Console::output('Роли установлены');
    }
}
