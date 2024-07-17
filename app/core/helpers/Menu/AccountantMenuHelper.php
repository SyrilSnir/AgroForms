<?php

namespace app\core\helpers\Menu;

use app\core\helpers\Utils\users\RolesHelper;
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
        $user = RolesHelper::getUser();
        return [     
            'items' => [
                [
                    'label' => Yii::t('app/menu', 'Request management'), 'icon' => 'icon-requests', 'url' => ['/panel/requests'],            
                ],
                [
                    'label' => Yii::t('app/menu', 'Documents'),
                    'icon' => 'file',
                    'url' => ['/panel/documents']
                ],                
            ]
        ];
    }

}
