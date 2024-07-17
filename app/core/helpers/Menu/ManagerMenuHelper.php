<?php

namespace app\core\helpers\Menu;

use app\models\ActiveRecord\Users\User;
use app\models\Data\Operations;
use Yii;

/**
 * Description of ManagerMenuHelper
 *
 * @author kotov
 */
class ManagerMenuHelper implements MenuHelperInterface
{
    public static function getMenu($params = []): array
    {
        /** @var User $user */
        $user = Yii::$app->user->getIdentity()->getUser();
                
        $items = [];
        
        if ($user->canOperation(Operations::ENTITY_DOCUMENT, Operations::OP_VIEW)) {
            $items[] = [
                    'label' => Yii::t('app/menu', 'Documents'),
                    'icon' => 'file',
                    'url' => ['/panel/documents']
                ];
        }
        if ($user->canOperation(Operations::ENTITY_RUBRICATOR, Operations::OP_VIEW)) {
            $items[] = ['label' => Yii::t('app/menu', 'Rubricator'), 'icon' => 'icon-cats', 'url' => ['/panel/lists/rubricator']];
        }
        
        
        return [
                'items' => $items
            ];
    }
    /*
[
                    [
                        'label' => Yii::t('app/menu', 'Users and companies'),
                        'icon' => 'icon-users-companies',
                        'items' => [
                            ['label' => Yii::t('app/menu', 'Users'), 'icon' => 'icon-users', 'url' => ['/panel/manager/users'],],
                            ['label' => Yii::t('app/menu', 'Companies'), 'icon' => 'icon-companies', 'url' => ['/panel/manager/companies'],],                            
                        ]
                    ],
                    [
                        'label' => Yii::t('app/menu', 'Contracts'),
                        'icon' => 'icon-requests',
                        'url' => ['/panel/contracts']
                    ],                    
                    [
                        'label' => Yii::t('app/menu', 'Viewing requests'), 'icon' => 'icon-requests', 'url' => ['/panel/requests'],
                    ]
                ]    
     */
}
