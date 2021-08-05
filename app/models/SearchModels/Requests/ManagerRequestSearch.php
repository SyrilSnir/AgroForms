<?php

namespace app\models\SearchModels\Requests;

use app\models\ActiveRecord\Requests\Request;
use yii\data\ActiveDataProvider;


/**
 * Description of AdminRequestSearch
 *
 * @author kotov
 */
class ManagerRequestSearch extends RequestSearch
{
    public function search(array $params): ActiveDataProvider
    {
        $dp = $this->baseSearch($params);
        $dp->query->andFilterWhere(['!=', 'status', Request::STATUS_DRAFT]);
        return $dp;        
    }
}
