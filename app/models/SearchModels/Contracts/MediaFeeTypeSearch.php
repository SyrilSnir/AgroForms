<?php

namespace app\models\SearchModels\Contracts;

use app\models\ActiveRecord\Contract\MediaFeeTypes;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of MediaFeeTypeSearch
 *
 * @author kotov
 */
class MediaFeeTypeSearch extends Model
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
        $query = MediaFeeTypes::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                //'defaultOrder' => ['order' => SORT_ASC]
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
