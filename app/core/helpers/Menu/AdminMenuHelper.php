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
                            'label' => Yii::t('app/menu', 'Users and roles'),
                            'icon' => 'user-circle',                             
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Users'), 'icon' => 'user', 'url' => ['/manage/users'],],
                                ['label' => Yii::t('app/menu', 'Roles'), 'icon' => 'universal-access', 'url' => ['/manage/roles'],],
                                ['label' => Yii::t('app/menu', 'Companies'), 'icon' => 'university ', 'url' => ['/manage/companies'],],

                            ]
                        ],
                        ['label' => Yii::t('app/menu', 'Exhibition management'), 'icon' => 'truck', 'url' => ['/manage/lists/exhibitions'],],                        
                        [
                            'label' => Yii::t('app/menu', 'Request management'),
                            'icon' => 'share',
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Request list'), 'icon' => 'tasks', 'url' => ['/manage/lists/requests'],],
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
                                ['label' => Yii::t('app/menu', 'Cities'), 'icon' => 'map-o', 'url' => ['/manage/geography/cities'],],
                                ['label' => Yii::t('app/menu', 'Regions'), 'icon' => 'map-o', 'url' => ['/manage/geography/regions'],],
                                ['label' => Yii::t('app/menu', 'Countries'), 'icon' => 'map-o', 'url' => ['/manage/geography/countries'],],
                            ]
                        ],
                        [
                            'label' => Yii::t('app/menu', 'Nomenclature'), 
                            'icon' => 'list', 
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Categories'), 'icon' => 'folder', 'url' => ['/manage/lists/equipment-groups'],],
                                ['label' => Yii::t('app/menu', 'Add. equipment'), 'icon' => 'gift', 'url' => ['/manage/lists/equipments'],],
                                ['label' => Yii::t('app/menu', 'Units measurement'), 'icon' => 'thermometer', 'url' => ['/manage/lists/units'],],
                            ]
                        ], 
                        ['label' => Yii::t('app/menu', 'Valutes'), 'icon' => 'money', 'url' => ['/manage/lists/valutes'],],
                    ],
                ],               
                [
                    'label' => Yii::t('app/menu', 'Settings'), 
                    'icon' => 'cog', 
                    'items' => [
                        [
                            'label' => Yii::t('app/menu', 'Forms constructor'),
                            'icon' => 'share',
                            'items' => [
                                ['label' => Yii::t('app/menu', 'List of forms'), 'icon' => 'tasks', 'url' => ['/manage/form/forms'],],
                                ['label' => Yii::t('app/menu', 'Form types'), 'icon' => 'tasks', 'url' => ['/manage/form/form-types'],],
                                ['label' => Yii::t('app/menu', 'Form fields'), 'icon' => 'tasks', 'url' => ['/manage/form/fields'],],
                                ['label' => Yii::t('app/menu', 'Field groups'), 'icon' => 'tasks', 'url' => ['/manage/form/field-groups'],],
                                ['label' => Yii::t('app/menu', 'Form elements'), 'icon' => 'tasks', 'url' => ['/manage/form/element-types'],],

                            ]
                        ], 
                        [
                            'label' =>  Yii::t('app/menu', 'Standard stand'),
                            'icon' => 'share',
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Stand management'), 'icon' => 'tasks', 'url' => ['/manage/form/stands'],],
                                ['label' => Yii::t('app/menu', 'Stand settings'), 'icon' => 'cogs', 'url' => ['/manage/form/stands/settings'],],
                            ]
                        ],                        
                        [ 'label' => Yii::t('app/menu', 'Mail server'), 'icon' => 'envelope-o', 'url' => ['/manage/config/mail-settings'],],
                    ]
                ]                 
            ]
        ];
    }

}
