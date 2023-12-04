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
                        'label' => Yii::t('app/menu', 'Request management'),
                        'icon' => 'arrow-right',
                        'items' => [
                            ['label' => Yii::t('app/menu', 'New applications'), 'icon' => 'icon-requests', 'url' => ['/panel/requests/new'],],
                            ['label' => Yii::t('app/menu', 'Accepted applications'), 'icon' => 'icon-requests', 'url' => ['/panel/requests/accepted'],],
                            ['label' => Yii::t('app/menu', 'Rejected applications'), 'icon' => 'icon-requests', 'url' => ['/panel/requests/rejected'],],
                        ]   
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

