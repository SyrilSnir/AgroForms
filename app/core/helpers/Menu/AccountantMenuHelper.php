<?php

namespace app\core\helpers\Menu;

use Yii;

/**
 * Description of AccountantMenuHelper
 *
 * @author kotov
 */
class AccountantMenuHelper implements MenuHelperInterface
{
    public static function getMenu($params = []): array
    {
        return [     
            'items' => [
                [
                    'label' => Yii::t('app/menu', 'Request management'), 'icon' => 'tasks', 'url' => ['/panel/requests'],            
                ]
            ]
        ];
    }

}
