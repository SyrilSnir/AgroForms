<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\SearchModels\Users;

use app\models\ActiveRecord\Users\queries\UserQuery;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;

/**
 * Description of MemberSearch
 *
 * @author kotov
 */
class MemberSearch extends BaseUserSearch
{
    protected function addFilters(UserQuery $query)
    {
        parent::addFilters($query);
        $query->andFilterWhere(['user_type_id' => UserType::MEMBER_USER_ID ]); 
        $query->andFilterWhere(['active' => User::STATUS_ACTIVE ]);
        $query->orFilterWhere(['active' => User::STATUS_NEW ]);
    }    
}
