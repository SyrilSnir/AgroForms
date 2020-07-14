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
    
    public $countryId;

    public $regionId;

    public function rules(): array
    {
        return [
            [['name'], 'safe'],
            [['countryId','regionId'], 'integer'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = City::find()->joinWith(['region'],true);
                
           /*     ->with(['country' => function($query) {
             $query->andWhere(['country_id' => 'id']);            
            }])*/;
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
        $query->andFilterWhere(['like','cities.name', $this->name]);
        $query->andFilterWhere(['country_id' => $this->countryId]);
        $query->andFilterWhere(['region_id' => $this->regionId]);
        return $dataProvider;
    }
    
    public function getCountries():array
    {
        return ArrayHelper::map(Country::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getRegions():array
    {
        $regions = Region::find();
        if ($this->countryId) {
            $regions->where(['country_id' => $this->countryId]);
        }        
        return ArrayHelper::map($regions->asArray()->all(), 'id', 'name');
    }
}
