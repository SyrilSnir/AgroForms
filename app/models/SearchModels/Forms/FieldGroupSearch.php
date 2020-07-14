<?php

namespace app\models\SearchModels\Forms;

use app\models\ActiveRecord\Forms\FieldGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of FieldGroupSearch
 *
 * @author kotov
 */
class FieldGroupSearch extends Model
{
    public $name;
    
    public $description;
    
    public function rules(): array
    {
        return [
            [['name', 'description'], 'safe'],
        ];
    }    
    public function search(array $params): ActiveDataProvider
    {
        $query = FieldGroup::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['order' => SORT_ASC]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like','name', $this->name]);
        $query->andFilterWhere(['like','description', $this->description]);
        return $dataProvider;
    }
}
