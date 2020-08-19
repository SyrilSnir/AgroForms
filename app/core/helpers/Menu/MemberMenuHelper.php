<?php

namespace app\core\helpers\Menu;

use app\models\ActiveRecord\Exhibition\Exhibition;

/**
 * Description of MemberMenuHelper
 *
 * @author kotov
 */
class MemberMenuHelper implements MenuHelperInterface
{
    //put your code here
    public static function getMenu($params = array()): array
    {
        
        return [
                    'items' => [
                        [
                            'label' => t('My exhibitions','menu'),
                            'icon' => 'folder',
                            'items' => self::getExhibitionList()
                           /* 'items' => [
                                [
                                    'label' => 'Агросалон 2020',
                                    'icon' => 'folder',
                                    'items' => [
                                        [
                                            'label' => t('My applications','menu'), 'icon' => 'wpforms', 'url' => ['/manage/member/requests'],
                                        ],
                                    ]   
                                ]
                            ]*/
                        ],
                        [
                            'label' => t('Personal data','menu'),
                            'icon' => 'user',
                            'items' => [                                                                    
                                [
                                    'label' => t('User profile','menu'), 'icon' => 'user-circle-o', 'url' => ['/manage/member/profile/user']
                                ],
                                [
                                    'label' => t('Company profile','menu'), 'icon' => 'building', 'url' => ['/manage/member/profile/company'],
                                ],                                                                       
                            ]
                        ]                                        
                    ]
                ];
    }
    
    public static function getExhibitionList():array
    {
        /** @var Exhibition $exhibition */
        $menuList = [];
        $exhibitions = Exhibition::find()->all();
        foreach ($exhibitions as $exhibition) {
            array_push($menuList,
                [
                    'label' => $exhibition->title,
                    'icon' => 'folder',
                    'items' => [
                        [
                            'label' => t('My applications','menu'), 'icon' => 'wpforms', 'url' => ["/manage/member/{$exhibition->id}/requests"],
                        ],
                    ]   
                ]                
            );
        }
        return $menuList;
    }

}
