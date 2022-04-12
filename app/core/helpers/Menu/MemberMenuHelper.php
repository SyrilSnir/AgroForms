<?php

namespace app\core\helpers\Menu;

use app\core\manage\Auth\UserIdentity;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Exhibition\Exhibition;

/**
 * Description of MemberMenuHelper
 *
 * @author kotov
 */
class MemberMenuHelper implements MenuHelperInterface
{
    /**
     * 
     * @var Company
     */
    private static $company;
    
    public static function getMenu($params = []): array
    {
        if (key_exists('user', $params)) {
            /** @var UserIdentity $user */
            $user = $params['user'];
            self::$company = $user->getCompany();
        }        
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
    
    private static function getExhibitionList():array
    {
        /** @var Exhibition $exhibition */
        $menuList = [];
        $exhibitions = self::$company->getAvailableExhibitions();
        foreach ($exhibitions as $exhibition) {
            $menu = [
                'label' => $exhibition->title,
                'icon' => 'icon-exhibitions',                
            ];
            
            $menuItems = [];
            $contracts = $exhibition->getConrtactsForCompany(self::$company->id);
            foreach ($contracts as $contract) {
                $menuItems[] = [
                    'contract' => $contract->number ,
                    'label' => t('My applications','menu'), 
                    'icon' => 'icon-requests', 
                    'url' => ["/panel/member/{$exhibition->id}/requests/{$contract->id}"],
                ];
            }
            $menu['items'] = $menuItems;
            array_push($menuList,$menu);
        }
        return $menuList;
    }

}
