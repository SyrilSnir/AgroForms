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
    public $title_eng;
    public $description;
    public $description_eng;
    
    
    public function rules(): array
    {
        return [
            [['title','title_eng','description','description_eng'], 'safe'],
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
        $query->andFilterWhere(['like','title_eng', $this->title_eng]);
        $query->andFilterWhere(['like','description', $this->description]);
        $query->andFilterWhere(['like','description_eng', $this->description_eng]);
        return $dataProvider;
    }
}
