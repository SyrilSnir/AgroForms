<?php

namespace app\core\helpers\Menu;

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
                            'items' => [
                                [
                                    'label' => 'Агросалон 2020',
                                    'icon' => 'folder',
                                    'items' => [
                                        [
                                            'label' => 'Мои заявки', 'icon' => 'wpforms', 'url' => ['/manage/member/requests'],
                                        ],
                                    ]   
                                ]
                            ]
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

}
