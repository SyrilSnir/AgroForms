<?php

namespace app\models\SearchModels\Nomenclature;

use app\models\ActiveRecord\Nomenclature\Unit;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of UnitSearch
 *
 * @author kotov
 */
class UnitSearch extends Model
{
    public $name; 
    
    public $short_name;


    public function rules(): array
    {
        return [
            [['name', 'short_name'], 'safe'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = Unit::find();
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
        $query->andFilterWhere(['like','short_name', $this->short_name]);
        return $dataProvider;
    }
}
