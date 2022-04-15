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
                            'label' => Yii::t('app/menu', 'Users and companies'),
                            'icon' => 'icon-users-companies',                             
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Users'), 'icon' => 'icon-users', 'url' => ['/panel/users'],],
                          /*      ['label' => Yii::t('app/menu', 'Roles'), 'icon' => 'universal-access', 'url' => ['/panel/roles'],],*/
                                ['label' => Yii::t('app/menu', 'Companies'), 'icon' => 'icon-companies', 'url' => ['/panel/companies'],],
                                ['label' => Yii::t('app/menu', 'Exhibition management'), 'icon' => 'icon-exhibitions', 'url' => ['/panel/lists/exhibitions'],],                        
                                [
                                    'label' => Yii::t('app/menu', 'Request management'),
                                    'icon' => 'icon-requests',
                                    'url' => ['/panel/requests']
                                ],   
                                [
                                    'label' => Yii::t('app/menu', 'Contracts'),
                                    'icon' => 'icon-requests',
                                    'url' => ['/panel/contracts']
                                ],
                                [
                                    'label' => Yii::t('app/menu', 'Documents'),
                                    'icon' => 'file',
                                    'url' => ['/panel/documents']
                                ],                                 
                            ]
                        ],
              
                        [
                            'label' => Yii::t('app/menu', 'Form management'),
                            'icon' => 'tasks',
                            'items' => [
                                [
                                    'label' =>  Yii::t('app/menu', 'Standard stand'),
                                    'icon' => 'share',
                                    'items' => [
                                    ]
                                ],                                
                            ]
                        ],                         
  
                        ['label' => Yii::t('app/menu', 'Geography'), 
                            'icon' => 'icon-geo', 
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Cities'), 'icon' => 'icon-cities', 'url' => ['/panel/geography/cities'],],
                                ['label' => Yii::t('app/menu', 'Regions'), 'icon' => 'icon-regions', 'url' => ['/panel/geography/regions'],],
                                ['label' => Yii::t('app/menu', 'Countries'), 'icon' => 'icon-countries', 'url' => ['/panel/geography/countries'],],
                            ]
                        ],
                        [
                            'label' => Yii::t('app/menu', 'Nomenclature'), 
                            'icon' => 'icon-nomenclature', 
                            'items' => [
                                ['label' => Yii::t('app/menu', 'Categories'), 'icon' => 'icon-cats', 'url' => ['/panel/lists/equipment-groups'],],
                                ['label' => Yii::t('app/menu', 'Add. equipment'), 'icon' => 'icon-equipment', 'url' => ['/panel/lists/equipments'],],
                                ['label' => Yii::t('app/menu', 'Units measurement'), 'icon' => 'icon-units', 'url' => ['/panel/lists/units'],],
                                ['label' => Yii::t('app/menu', 'Valutes'), 'icon' => 'icon-valutes', 'url' => ['/panel/lists/valutes'],],                                  
                            ]
                        ], 
             
                [
                    'label' => Yii::t('app/menu', 'Settings'), 
                    'icon' => 'icon-settings', 
                    'items' => [                  
                        [
                            'label' => Yii::t('app/menu', 'Forms constructor'),
                            'url' => ['/panel/forms'],
                            'icon' => 'icon-forms',
                        ],   
                        ['label' => Yii::t('app/menu', 'Stand management'), 'icon' => 'icon-stands', 'url' => ['/panel/stands'],],
                        ['label' => Yii::t('app/menu', 'Stand settings'), 'icon' => 'icon-stand-settings', 'url' => ['/panel/stands/settings'],],                        
                        [ 'label' => Yii::t('app/menu', 'Mail server'), 'icon' => 'icon-mail', 'url' => ['/panel/config/mail-settings'],],
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
