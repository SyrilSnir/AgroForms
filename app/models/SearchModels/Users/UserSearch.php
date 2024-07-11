<?php

namespace app\models\SearchModels\Users;

use app\core\traits\Lists\GetManagerRolesTrait;
use app\core\traits\Lists\GetUserTypeListTrait;
use app\models\ActiveRecord\Users\queries\UserQuery;
use yii\helpers\ArrayHelper;

/**
 * Description of UserSearch
 *
 * @author kotov
 */
class UserSearch extends BaseUserSearch
{   
    public $active;
    
    public $user_type_id;  
    
    public $role_id;

    use GetUserTypeListTrait, GetManagerRolesTrait;
    
    protected function addFilters(UserQuery $query)
    {
        $query->andFilterWhere(['active' => $this->active]);
        $query->andFilterWhere(['user_type_id' => $this->user_type_id]);         
        $query->andFilterWhere(['role_id' => $this->role_id]);         
        parent::addFilters($query);
    }
    public function rules(): array
    {
        $rules = [
            [['active','user_type_id','role_id'], 'integer'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    }
    
    protected function addStaticFilters(UserQuery $query)
    {
        $query->andFilterWhere(['deleted' => false]);        
    }    
}
