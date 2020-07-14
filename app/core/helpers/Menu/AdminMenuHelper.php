<?php

namespace app\core\helpers\Menu;

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
                    'label' => 'Администрирование',
                    'icon' => 'cog',
                    'items' => [
                        [
                            'label' => 'Пользователи и роли', 
                            'icon' => 'user-circle',                             
                            'items' => [
                                ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/manage/users'],],
                                ['label' => 'Роли', 'icon' => 'universal-access', 'url' => ['/manage/roles'],],
                                ['label' => 'Компании', 'icon' => 'university ', 'url' => ['/manage/companies'],],

                            ]
                        ],
                        [
                            'label' => 'Управление заявкими',
                            'icon' => 'share',
                            'items' => [
                                ['label' => 'Список заявок', 'icon' => 'tasks', 'url' => ['/manage/lists/requests'],],
                            ]
                        ],                        
                        [
                            'label' => 'Управление формами',
                            'icon' => 'share',
                            'items' => [
                                ['label' => 'Список форм', 'icon' => 'tasks', 'url' => ['/manage/form/forms'],],
                                ['label' => 'Типы форм', 'icon' => 'tasks', 'url' => ['/manage/form/form-types'],],
                                ['label' => 'Поля формы', 'icon' => 'tasks', 'url' => ['/manage/form/fields'],],
                                ['label' => 'Группы полей', 'icon' => 'tasks', 'url' => ['/manage/form/field-groups'],],
                                ['label' => 'Типы элементов', 'icon' => 'tasks', 'url' => ['/manage/form/element-types'],],

                            ]
                        ],
                        [
                            'label' => 'Стандартный стенд',
                            'icon' => 'share',
                            'items' => [
                                ['label' => 'Управление стендами', 'icon' => 'tasks', 'url' => ['/manage/form/stands'],],
                                ['label' => 'Настройки стендов', 'icon' => 'cogs', 'url' => ['/manage/form/stands/settings'],],
                            ]
                        ], 
                        [
                            'label' => 'Справочники',
                            'icon' => 'share',
                            'items' => [
                                ['label' => 'География', 
                                    'icon' => 'map', 
                                    'items' => [
                                        ['label' => 'Города', 'icon' => 'map-o', 'url' => ['/manage/geography/cities'],],
                                        ['label' => 'Регионы', 'icon' => 'map-o', 'url' => ['/manage/geography/regions'],],
                                        ['label' => 'Страны', 'icon' => 'map-o', 'url' => ['/manage/geography/countries'],],
                                    ]
                                ],
                                [
                                    'label' => 'Номенклатурв', 
                                    'icon' => 'list', 
                                    'items' => [
                                        ['label' => 'Категории', 'icon' => 'folder', 'url' => ['/manage/lists/equipment-groups'],],
                                        ['label' => 'Доп. оборудование', 'icon' => 'gift', 'url' => ['/manage/lists/equipments'],],
                                        ['label' => 'Единицы измерения', 'icon' => 'thermometer', 'url' => ['/manage/lists/units'],],
                                    ]
                                ],                               
                            ],
                        ],
                        [
                            'label' => 'Настройки', 
                            'icon' => 'cog', 
                            'items' => [
                                [ 'label' => 'Почтовый сервер', 'icon' => 'envelope-o', 'url' => ['/manage/config/mail-settings'],],
                            ]
                        ]                        
                    ],
                ],                        
            ]
        ];
    }

}
