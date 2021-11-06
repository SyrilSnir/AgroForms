<?php

namespace app\models\SearchModels\Requests;

use app\models\ActiveRecord\Requests\BaseRequest;

/**
 * Description of AccountantRequestSearch
 *
 * @author kotov
 */
class AccountantRequestSearch extends ManagerRequestSearch
{
    public function search(array $params = [])
    {
        $dp = parent::search($params);
        $dp->query->andFilterWhere(['!=', 'status', BaseRequest::STATUS_NEW]);        
        $dp->query->andFilterWhere(['!=', 'status', BaseRequest::STATUS_REJECTED]);        
        $dp->query->andFilterWhere(['!=', 'status', BaseRequest::STATUS_CHANGED]); 
        return $dp;
    }
}
