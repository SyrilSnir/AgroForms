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
        
        if ($user->canOperation(Operations::ENTITY_USER, Operations::OP_VIEW)) {
            $items[] = ['label' => Yii::t('app/menu', 'Users'), 'icon' => 'icon-users', 'url' => ['/panel/manager/users'],];
        }
        if ($user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_VIEW)) {
            $items[] = ['label' => Yii::t('app/menu', 'Companies'), 'icon' => 'icon-companies', 'url' => ['/panel/companies']];
            $items[] = ['label' => Yii::t('app/menu', 'Geography'), 
                            'icon' => 'icon-geo', 
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Cities'), 'icon' => 'icon-cities', 'url' => ['/panel/geography/cities'],],
                                ['label' => Yii::t('app/menu', 'Regions'), 'icon' => 'icon-regions', 'url' => ['/panel/geography/regions'],],
                                ['label' => Yii::t('app/menu', 'Countries'), 'icon' => 'icon-countries', 'url' => ['/panel/geography/countries'],],
                            ]
                        ];               
        }        
        if ($user->canOperation(Operations::ENTITY_CONTRACT, Operations::OP_VIEW)) {
            $items[] = [
                    'label' => Yii::t('app/menu', 'Documents'),
                    'icon' => 'file',
                    'url' => ['/panel/documents']
                ];
        }
        
        if ($user->canOperation(Operations::ENTITY_DOCUMENT, Operations::OP_VIEW)) {
            $items[] = [
                                    'label' => Yii::t('app/menu', 'Contracts'),
                                    'icon' => 'icon-requests',
                                    'url' => ['/panel/contracts']
                                ];
        }
        if ($user->canOperation(Operations::ENTITY_RUBRICATOR, Operations::OP_VIEW)) {
            $items[] = ['label' => Yii::t('app/menu', 'Rubricator'), 'icon' => 'icon-cats', 'url' => ['/panel/lists/rubricator']];
        }
        if ($user->canOperation(Operations::ENTITY_CATALOG, Operations::OP_VIEW)) {
            $items[] = [
                        'label' => t('Catalog','menu'),
                        'icon' => 'list-ul',
                        'url' => ['/panel/catalog']
                ];
        }
        if ($user->canRequestAccess()) {
            $items[] = [
                            'label' => Yii::t('app/menu', 'Request management'),
                            'icon' => 'arrow-right',
                            'items' => [
                                ['label' => Yii::t('app/menu', 'New applications'), 'icon' => 'icon-requests', 'url' => ['/panel/requests/new'],],
                                ['label' => Yii::t('app/menu', 'Accepted applications'), 'icon' => 'icon-requests', 'url' => ['/panel/requests/accepted'],],
                                ['label' => Yii::t('app/menu', 'Rejected applications'), 'icon' => 'icon-requests', 'url' => ['/panel/requests/rejected'],],
                            ]   
                        ];
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
