<?php

namespace app\models\SearchModels\Exhibition;

use app\models\ActiveRecord\Exhibition\Exhibition;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of ExhibitionSearch
 *
 * @author kotov
 */
class ExhibitionSearch extends Model
{
    public $title;
    
    
    public function rules(): array
    {
        return [
            [['title'], 'safe'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = Exhibition::find();
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
        $query->andFilterWhere(['like','title', $this->title]);
        return $dataProvider;
    }
}
