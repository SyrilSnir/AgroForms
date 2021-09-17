<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\SearchModels\Requests;

use app\models\ActiveRecord\Requests\Request;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of RequestStandSearch
 *
 * @author kotov
 */
class RequestStandSearch extends Model
{
    public $name;
    
    public function rules(): array
    {
        return [
           // [['name'], 'safe'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = Request::find()->joinWith('stands',true,'RIGHT JOIN');
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
