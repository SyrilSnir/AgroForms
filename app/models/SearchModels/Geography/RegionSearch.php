<?php

namespace app\models\SearchModels\Geography;

use app\models\ActiveRecord\Geography\Region;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of RegionSearch
 *
 * @author kotov
 */
class RegionSearch extends Model
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
        $query = Region::find();
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
