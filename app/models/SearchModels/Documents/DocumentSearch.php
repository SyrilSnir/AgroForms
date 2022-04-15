<?php

namespace app\models\SearchModels\Documents;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetExhibitionsTrait;
use app\models\ActiveRecord\Document\Documents;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of DocumentSearch
 *
 * @author kotov
 */
class DocumentSearch extends Model
{
    public $company_id;  
    
    public $exhibition_id;
    
    use GetCompanyNamesTrait, GetExhibitionsTrait;
    
    public function search(array $params): ActiveDataProvider   
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
        $query->andFilterWhere(['company_id' => $this->company_id]);   
        return $dataProvider;        
    }

    public function rules(): array
    {
        return [
            [['company_id','exhibition_id'], 'safe']
        ];        
    }    
}
