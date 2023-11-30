<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\SearchModels\Requests;

use app\models\ActiveRecord\Requests\BaseRequest;

/**
 * Description of ManagerRequestSearch
 *
 * @author kotov
 */
class ManagerRequestSearch extends RequestSearch
{
    public function search(array $params = [])
    {
        $dp = $this->baseSearch($params);
        $dp->query->andFilterWhere(['!=', 'requests.status', BaseRequest::STATUS_DRAFT]);
        return $dp;
    }
}
