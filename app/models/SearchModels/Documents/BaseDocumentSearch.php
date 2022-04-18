<?php

namespace app\models\SearchModels\Documents;

use app\models\ActiveRecord\Document\Documents;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of BaseDocumentSearch
 *
 * @author kotov
 */
abstract class BaseDocumentSearch extends Model
{
    public $title;
    
    public $description;
      
    protected function baseSearch(array $params = [])
    {
        $query = Documents::find();
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
        $query->andFilterWhere(['like', 'title',$this->title]);   
        $query->andFilterWhere(['like', 'description',$this->description]);   
        return $dataProvider;   
    }
    
    public function rules(): array
    {
        return [
            [['title','description'], 'safe']
        ];        
    } 
}
