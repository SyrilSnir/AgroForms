<?php

namespace app\models\SearchModels\Contracts;

use app\models\ActiveRecord\Contract\StandNumber;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of StandNumberSearch
 *
 * @author kotov
 */
class StandNumberSearch extends Model
{
    public $number;
    
    public function rules(): array
    {
        return [
            [['number'], 'safe'],
        ];
    }
    
    public function search(array $params): ActiveDataProvider   
    {
        $query = StandNumber::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                //'defaultOrder' => ['order' => SORT_ASC]
            ]
        ]);  
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like','number', $this->number]);  
        return $dataProvider;        
    }
}
