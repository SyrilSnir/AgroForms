<?php

namespace app\models\SearchModels\Nomenclature;

use app\models\ActiveRecord\Nomenclature\EquipmentGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of CategorySearch
 *
 * @author kotov
 */
class EquipmentGroupSearch extends Model
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
        $query = EquipmentGroup::find();
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
