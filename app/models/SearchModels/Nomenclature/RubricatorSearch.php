<?php

namespace app\models\SearchModels\Nomenclature;

use app\core\traits\Lists\GetRubricatorTrait;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of RubricatorSearch
 *
 * @author kotov
 */
class RubricatorSearch extends Model
{
    use GetRubricatorTrait;
    
    public $name; 
    public $parentId; 

    public function rules(): array
    {
        return [
            [['name','parentId'], 'safe'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $this->load($params);
        if (empty($this->parentId)) {
            $query = Rubricator::find();
        } else {
            $query = Rubricator::findOne($this->parentId)->children();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like','name', $this->name]);
        return $dataProvider;
    }
}
