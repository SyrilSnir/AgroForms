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
                        'label' => 'Агросалон 2020',
                        'icon' => 'folder',
                        'items' => [
                            [
                                'label' => 'Мои заявки', 'icon' => 'wpforms', 'url' => ['/manage/member/requests'],],
                            ]   
                    ]
                ]
            ];
    }

}
