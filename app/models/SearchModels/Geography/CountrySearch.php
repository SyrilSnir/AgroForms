<?php

namespace app\models\SearchModels\Geography;

use app\models\ActiveRecord\Geography\Country;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of CountrySearch
 *
 * @author kotov
 */
class CountrySearch extends Model
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
        $query = Country::find();
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
        $query->andFilterWhere(['like','name', $this->name]);
        return $dataProvider;
    }
}

