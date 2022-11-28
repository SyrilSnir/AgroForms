<?php

namespace app\models\SearchModels\Users;

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

    use GetUserTypeListTrait;
    
    protected function addFilters(UserQuery $query)
    {
        $query->andFilterWhere(['active' => $this->active]);
        $query->andFilterWhere(['user_type_id' => $this->user_type_id]);        
        parent::addFilters($query);
    }
    public function rules(): array
    {
        $rules = [
            [['active','user_type_id'], 'integer'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    }
    
    protected function addStaticFilters(UserQuery $query)
    {
        $query->andFilterWhere(['deleted' => false]);        
    }    
}
