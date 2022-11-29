<?php

namespace app\models\SearchModels\Contracts;

use app\models\ActiveRecord\Contract\Hall;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of HallSearch
 *
 * @author kotov
 */
class HallSearch extends Model
{
    public $name;
    
    public function rules(): array
    {
        return [
            [['name'], 'safe'],
        ];
    }
    
    public function search(array $params): ActiveDataProvider   
    {
        $query = Hall::find();
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
        $query->andFilterWhere(['like','name', $this->name]);  
        return $dataProvider;        
    }    
}
