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
 *
 * @author kotov
 */
trait ManagerSearchTrait
{
    public function search(array $params): ActiveDataProvider
    {
        $dp = parent::search($params);
        $dp->query->andFilterWhere(['!=', 'status', BaseRequest::STATUS_DRAFT]);
        return $dp;        
    }    
}
