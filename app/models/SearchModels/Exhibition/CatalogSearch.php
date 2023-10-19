<?php

namespace app\models\SearchModels\Exhibition;

use app\core\traits\Lists\GetExhibitionsTrait;
use app\models\ActiveRecord\Exhibition\Catalog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of CatalogSearch
 *
 * @author kotov
 */
class CatalogSearch extends Model
{
    use GetExhibitionsTrait;
    
    public $company;
    
    public $exhibition_id;
    
    public function rules(): array
    {
        return [
            [['company','exhibition_id'], 'safe'],
        ];
    }
    
    public function search(array $params): ActiveDataProvider   
    {
        $query = Catalog::find();
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
        $query->andFilterWhere(['like','company', $this->company]);  
        $query->andFilterWhere(['exhibition_id' => $this->exhibition_id]);  
        return $dataProvider;        
    } 
}
