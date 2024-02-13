<?php

namespace app\models\SearchModels\Geography;

use app\models\ActiveRecord\Geography\City;
use app\models\ActiveRecord\Geography\Country;
use app\models\ActiveRecord\Geography\Region;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Description of CitySearch
 *
 * @author kotov
 */
class CitySearch extends Model
{
    public $name;
    
    public $country_id;

    public $region_id;

    public function rules(): array
    {
        return [
            [['name'], 'safe'],
            [['country_id','region_id'], 'integer'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = City::find()->select(['{{cities}}.*', '{{regions}}.country_id'])->joinWith(['region'],true);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'name',
                    'region_id',
                    'country_id'
                ],
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->orFilterWhere(['like','cities.name', $this->name])
              ->orFilterWhere(['like','cities.name_eng', $this->name]);
        $query->andFilterWhere(['country_id' => $this->country_id]);
        $query->andFilterWhere(['region_id' => $this->region_id]);
        return $dataProvider;
    }
    
    public function getCountries():array
    {
        return ArrayHelper::map(Country::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getRegions():array
    {
        $regions = Region::find();
        if ($this->country_id) {
            $regions->where(['country_id' => $this->country_id]);
        }        
        return ArrayHelper::map($regions->asArray()->all(), 'id', 'name');
    }
}
