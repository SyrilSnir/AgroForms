<?php

namespace app\models\SearchModels\Users;

use app\core\traits\Lists\GetUserTypeListTrait;
use app\models\ActiveRecord\Users\queries\UserQuery;
use yii\helpers\ArrayHelper;

/**
 * Description of TrashUserSearch
 *
 * @author kotov
 */
class TrashUserSearch extends BaseUserSearch
{    
    public $user_type_id;    

    use GetUserTypeListTrait;
    
    protected function addFilters(UserQuery $query)
    {      
        $query->andFilterWhere(['user_type_id' => $this->user_type_id]);           
        parent::addFilters($query);
    }
    
    protected function addStaticFilters(UserQuery $query)
    {
        $query->andFilterWhere(['deleted' => true]);        
    }    
    
    public function rules(): array
    {
        $rules = [
            [['user_type_id'], 'integer'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    }    
}
