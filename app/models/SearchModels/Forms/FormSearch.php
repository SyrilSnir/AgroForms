<?php

namespace app\models\SearchModels\Forms;

use app\models\ActiveRecord\Forms\Form;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of FormSearch
 *
 * @author kotov
 */
class FormSearch extends Model
{
    public $name;
    
    public $title;
    
    public function rules(): array
    {
        return [
            [['name', 'title'], 'safe'],
        ];
    }    
    public function search(array $params): ActiveDataProvider
    {
        $query = Form::find();
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
        $query->andFilterWhere(['like','title', $this->title]);
        return $dataProvider;
    }
}
