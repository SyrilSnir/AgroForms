<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\SearchModels\Requests;

use app\models\ActiveRecord\Requests\BaseRequest;
use yii\data\ActiveDataProvider;

/**
 * Description of AdminRequestStandSearch
 *
 * @author kotov
 */
class AdminRequestStandSearch extends RequestStandSearch
{
    public function search(array $params): ActiveDataProvider
    {
        $dp = parent::search($params);
        $dp->query->andFilterWhere(['!=', 'requests.status', BaseRequest::STATUS_DRAFT]);
        return $dp;
    }
}
