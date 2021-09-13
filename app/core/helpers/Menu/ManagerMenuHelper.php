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
                        'icon' => 'user-circle',
                        'items' => [
                            ['label' => Yii::t('app/menu', 'Users'), 'icon' => 'user', 'url' => ['/panel/manager/users'],],
                            ['label' => Yii::t('app/menu', 'Companies'), 'icon' => 'university ', 'url' => ['/panel/manager/companies'],],                            
                        ]
                    ],
                ]
            ];
    }

}
