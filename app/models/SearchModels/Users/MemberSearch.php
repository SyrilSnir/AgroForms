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
use yii\helpers\ArrayHelper;

/**
 * Description of MemberSearch
 *
 * @author kotov
 */
class MemberSearch extends BaseUserSearch
{
    public $active;
    
    public function rules(): array
    {
        $rules = [
            [['active'], 'integer'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    }    
    protected function addFilters(UserQuery $query)
    {
        parent::addFilters($query);
        $query->andFilterWhere(['active' => $this->active]);
        $query->andFilterWhere(['user_type_id' => UserType::MEMBER_USER_ID ]); 
        $query->andFilterWhere(['or', 
            ['active' => User::STATUS_ACTIVE],
            ['active' => User::STATUS_NEW ] ]);
    }    
}
