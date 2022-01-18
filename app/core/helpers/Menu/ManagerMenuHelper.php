<?php

namespace app\core\helpers\Menu;

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
        return [
                'items' => [
                    [
                        'label' => Yii::t('app/menu', 'Users and companies'),
                        'icon' => 'icon-users-companies',
                        'items' => [
                            ['label' => Yii::t('app/menu', 'Users'), 'icon' => 'icon-users', 'url' => ['/panel/manager/users'],],
                            ['label' => Yii::t('app/menu', 'Companies'), 'icon' => 'icon-companies', 'url' => ['/panel/manager/companies'],],                            
                        ]
                    ],
                    [
                        'label' => Yii::t('app/menu', 'Viewing requests'), 'icon' => 'icon-requests', 'url' => ['/panel/requests'],
                    ]
                ]
            ];
    }

}
