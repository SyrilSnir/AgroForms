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
                            'icon' => 'icon-exhibitions',
                            'items' => self::getExhibitionList()
                        ],
                        [
                            'label' => t('Personal data','menu'),
                            'icon' => 'icon-users-companies',
                            'items' => [                                                                    
                                [
                                    'label' => t('User profile','menu'), 'icon' => 'icon-users', 'url' => ['/panel/member/profile/user']
                                ],
                                [
                                    'label' => t('Company profile','menu'), 'icon' => 'icon-companies', 'url' => ['/panel/member/profile/company'],
                                ],                                                                       
                            ]
                        ],
                        [
                            'label' => t('Feedback form','menu'),
                            'icon' => 'comment',
                             'url' => ['/panel/member/feedback']
                        ],                        
                    ]
                ];
    }
    
    public static function getExhibitionList():array
    {
        /** @var Exhibition $exhibition */
        $menuList = [];
        $exhibitions = Exhibition::find()->orderBy(['end_date' => SORT_DESC])->all();
        foreach ($exhibitions as $exhibition) {
            array_push($menuList,
                [
                    'label' => $exhibition->title,
                    'icon' => 'icon-exhibitions',
                    'items' => [
                        [
                            'label' => t('My applications','menu'), 'icon' => 'icon-requests', 'url' => ["/panel/member/{$exhibition->id}/requests"],
                        ],
                    ]   
                ]                
            );
        }
        return $menuList;
    }

}
