<?php

namespace app\models\SearchModels\Nomenclature;

use app\core\traits\Lists\GetCategoriesListTrait;
use app\core\traits\Lists\GetUnitsTrait;
use app\models\ActiveRecord\Nomenclature\Equipment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of EquipmentSearch
 *
 * @author kotov
 */
class EquipmentSearch extends Model
{
    use GetCategoriesListTrait, GetUnitsTrait;
    
    public $name;
    
    public $code;
    
    public $description;
    
    public $group_id;
    
    public $unit_id;

    public function rules(): array
    {
        return [
            [['name', 'code','description','group_id','unit_id'], 'safe'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = Equipment::find()->joinWith('equipmentGroup')->joinWith('unit');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'name',
                    'code',
                    'description',
                    'group_id' => [
                        'asc' => ['{{%equipment_groups}}.name' => SORT_ASC],
                        'desc' => ['{{%equipment_groups}}.name' => SORT_DESC],
                    ],
                    'unit_id' => [
                        'asc' => ['{{%units}}.name' => SORT_ASC],
                        'desc' => ['{{%units}}.name' => SORT_DESC],
                    ],                                        
                ],
           //     'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like','name', $this->name]);
        $query->andFilterWhere(['like','code', $this->code]);
        $query->andFilterWhere(['like','description', $this->description]);
        $query->andFilterWhere(['group_id' => $this->group_id]);
        $query->andFilterWhere(['unit_id' => $this->unit_id]);
        return $dataProvider;
    }
}
