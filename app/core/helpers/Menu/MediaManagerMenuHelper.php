<?php

namespace app\core\helpers\Menu;

use Yii;

/**
 * Description of MediaManagerMenuHelper
 *
 * @author kotov
 */
class MediaManagerMenuHelper implements MenuHelperInterface
{
    public static function getMenu($params = []): array
    {
        return [
                'items' => [                    
                    [
                        'label' => Yii::t('app/menu', 'Viewing requests'), 'icon' => 'icon-requests', 'url' => ['/panel/requests'],
                    ],
                    [
                        'label' => t('Catalog','menu'),
                        'icon' => 'list-ul',
                         'url' => ['/panel/catalog']
                    ],                    
                ]
            ];
    }

}

