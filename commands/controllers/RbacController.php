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
        
        $superAdmin = $auth->createRole(UserType::SUPER_ADMIN);
        $superAdmin->description = 'Супер администратор';
        $auth->add($superAdmin);
        
        $admin = $auth->createRole(UserType::ROOT_USER_TYPE);
        $admin->description = 'Администратор';
        $auth->add($admin);
        
        $member = $auth->createRole(UserType::MEMBER_USER_TYPE);
        $member->description = 'Роль участника выставки';
        $auth->add($member);
        
        $organizer = $auth->createRole(UserType::ORGANIZER_USER_TYPE);
        $organizer->description = 'Роль организатора';
        $auth->add($organizer);
        
        $accountant = $auth->createRole(UserType::ACCOUNTANT_USER_TYPE);
        $accountant->description = 'Роль бухгалтера';
        $auth->add($accountant);
        
        $manager = $auth->createRole(UserType::MANAGER_USER_TYPE);
        $manager->description = 'Роль менеджера';
        $auth->add($manager);
        
        $adminMenu = $auth->createPermission(Rbac::PERMISSION_ADMINISTRATOR_MENU);
        $adminMenu->description ='Меню администратора';
        $auth->add($adminMenu);
        $auth->addChild($admin, $adminMenu);
        
        $memberMenu = $auth->createPermission(Rbac::PERMISSION_MEMBER_MENU);
        $memberMenu->description = 'Меню участника выставки';
        $auth->add($memberMenu);
        $auth->addChild($member, $memberMenu);
        
        $organizerMenu = $auth->createPermission(Rbac::PERMISSION_ORGANIZER_MENU);
        $organizerMenu->description = 'Меню организатора';
        $auth->add($organizerMenu);
        $auth->addChild($organizer, $organizerMenu);
        
        $managerMenu = $auth->createPermission(Rbac::PERMISSION_MANAGER_MENU);
        $managerMenu->description = 'Меню менеджера выставки';
        $auth->add($managerMenu);
        $auth->addChild($manager, $managerMenu);
        
        $accountantMenu = $auth->createPermission(Rbac::PERMISSION_ACCOUNTANT_MENU);
        $accountantMenu->description = 'Меню бухгалтера';
        $auth->add($accountantMenu);
        $auth->addChild($accountant, $accountantMenu);
        
        Console::output('Роли установлены');
    }
}
