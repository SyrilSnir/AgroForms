<?php

namespace app\models\SearchModels\Common;

use app\models\ActiveRecord\Common\Valute;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of ValuteSearch
 *
 * @author kotov
 */
class ValuteSearch extends Model
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
        $query = Valute::find();
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
