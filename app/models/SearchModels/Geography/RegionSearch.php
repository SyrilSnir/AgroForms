<?php

namespace app\models\SearchModels\Geography;

use app\core\traits\Lists\GetCountriesTrait;
use app\models\ActiveRecord\Geography\Region;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of RegionSearch
 *
 * @author kotov
 */
class RegionSearch extends Model
{
    use GetCountriesTrait;
    
    public $name;
    
    public $country_id;


    public function rules(): array
    {
        return [
            [['name'], 'safe'],
            [['country_id'], 'integer'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = Region::find();
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
        $query->orFilterWhere(['like','name', $this->name])
              ->orFilterWhere(['like','name_eng', $this->name]);
        $query->andFilterWhere(['country_id' => $this->country_id]);
        return $dataProvider;
    }
      
}
