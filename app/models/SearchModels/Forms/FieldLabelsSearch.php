<?php

namespace app\models\SearchModels\Forms;

use app\models\ActiveRecord\Forms\FieldLabels;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of FieldLabelsSearch
 *
 * @author kotov
 */
class FieldLabelsSearch extends Model
{
    public $name;
    
    public $code;
    
    public function rules(): array
    {
        return [
            [['name','code'], 'safe'],
        ];
    }    
    public function search(array $params): ActiveDataProvider
    {
        $query = FieldLabels::find();
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
        $query->andFilterWhere(['like','code', $this->code]);
        return $dataProvider;
    }
}
