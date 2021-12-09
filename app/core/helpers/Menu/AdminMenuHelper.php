<?php

namespace app\core\helpers\Menu;

use Yii;

/**
 * Description of AdminMenuHelper
 *
 * @author kotov
 */
class AdminMenuHelper implements MenuHelperInterface
{
    
    public static function getMenu($params = []): array
    {
        return [
          //  'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
            'items' => [
                [
                    'label' => Yii::t('app/menu', 'Administration'),
                    'icon' => 'cog',
                    'items' => [
                        [
                            'label' => Yii::t('app/menu', 'Users and companies'),
                            'icon' => 'user-circle',                             
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Users'), 'icon' => 'user', 'url' => ['/panel/users'],],
                          /*      ['label' => Yii::t('app/menu', 'Roles'), 'icon' => 'universal-access', 'url' => ['/panel/roles'],],*/
                                ['label' => Yii::t('app/menu', 'Companies'), 'icon' => 'university ', 'url' => ['/panel/companies'],],

                            ]
                        ],
                        ['label' => Yii::t('app/menu', 'Exhibition management'), 'icon' => 'truck', 'url' => ['/panel/lists/exhibitions'],],                        
                        [
                            'label' => Yii::t('app/menu', 'Request management'),
                            'icon' => 'tasks',
                            'url' => ['/panel/requests']
                        ],                        
                        [
                            'label' => Yii::t('app/menu', 'Form management'),
                            'icon' => 'tasks',
                            'items' => [
                                [
                                    'label' => Yii::t('app/menu', 'Forms constructor'),
                                    'url' => ['/panel/forms'],
                                    'icon' => 'pencil-square ',
                                ], 
                                [
                                    'label' =>  Yii::t('app/menu', 'Standard stand'),
                                    'icon' => 'share',
                                    'items' => [
                                        ['label' => Yii::t('app/menu', 'Stand management'), 'icon' => 'tasks', 'url' => ['/panel/stands'],],
                                        ['label' => Yii::t('app/menu', 'Stand settings'), 'icon' => 'cogs', 'url' => ['/panel/stands/settings'],],
                                    ]
                                ],                                
                            ]
                        ],                         
                    ],
                ], 
                [
                    'label' => Yii::t('app/menu', 'Directories'),
                    'icon' => 'share',
                    'items' => [
                        ['label' => Yii::t('app/menu', 'Geography'), 
                            'icon' => 'map', 
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Cities'), 'icon' => 'map-o', 'url' => ['/panel/geography/cities'],],
                                ['label' => Yii::t('app/menu', 'Regions'), 'icon' => 'map-o', 'url' => ['/panel/geography/regions'],],
                                ['label' => Yii::t('app/menu', 'Countries'), 'icon' => 'map-o', 'url' => ['/panel/geography/countries'],],
                            ]
                        ],
                        [
                            'label' => Yii::t('app/menu', 'Nomenclature'), 
                            'icon' => 'list', 
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Categories'), 'icon' => 'folder', 'url' => ['/panel/lists/equipment-groups'],],
                                ['label' => Yii::t('app/menu', 'Add. equipment'), 'icon' => 'gift', 'url' => ['/panel/lists/equipments'],],
                                ['label' => Yii::t('app/menu', 'Units measurement'), 'icon' => 'thermometer', 'url' => ['/panel/lists/units'],],
                            ]
                        ], 
                        ['label' => Yii::t('app/menu', 'Valutes'), 'icon' => 'money', 'url' => ['/panel/lists/valutes'],],
                    ],
                ],               
                [
                    'label' => Yii::t('app/menu', 'Settings'), 
                    'icon' => 'cog', 
                    'items' => [                        
                        [ 'label' => Yii::t('app/menu', 'Mail server'), 'icon' => 'envelope-o', 'url' => ['/panel/config/mail-settings'],],
                    ]
                ],
                [
                    'label' => t('Feedback','menu'),
                    'icon' => 'comment',
                     'url' => ['/panel/feedback']
                ],                  
                
            ]
        ];
    }

}
