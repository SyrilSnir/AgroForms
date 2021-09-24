<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\SearchModels\Requests;

use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\SearchInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of ApplicationSearch
 *
 * @author kotov
 */
class ApplicationSearch extends Model implements SearchInterface
{

    public $name;
    
    public function rules(): array
    {
        return [
            // [['name'], 'safe'],
        ];
    }

    public function searchForUser(int $userId,int $exhibitionId = null, array $params = []) : ActiveDataProvider
    {
        /** @var RequestQuery $query */
        $dp = $this->search($params);
        $query = $dp->query;
        
        $query = $query->forUser($userId);
        if ($exhibitionId) {
            $query = $query->forExhibition($exhibitionId);
        }
        return $dp;
    }
    
    public function search(array $params): ActiveDataProvider
    {
        $query = Request::find()->joinWith('applications',true,'RIGHT JOIN');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');           
            return $dataProvider;
        }
      //  $query->andFilterWhere(['like','name', $this->name]);
        return $dataProvider;
    }
}
