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
    public $status;
    public $description;
    
    
    public function rules(): array
    {
        return [
            [['title','description','status'], 'safe'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = Exhibition::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['start_date' => SORT_ASC]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like','title', $this->title]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like','description', $this->description]);

        return $dataProvider;
    }
}
