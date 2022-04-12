<?php

namespace app\models\SearchModels\Contracts;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\models\ActiveRecord\Contract\Contracts;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of ContractSearch
 *
 * @author kotov
 */
class ContractSearch extends Model
{
    public $number;
    
    public $company_id;  
    
    public $status;


    use GetCompanyNamesTrait;
    
    public function search(array $params): ActiveDataProvider   
    {
        $query = Contracts::find();
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
        $query->andFilterWhere(['number' => $this->number]);  
        $query->andFilterWhere(['status' => $this->status]);  
        return $dataProvider;        
    }

    public function rules(): array
    {
        return [
            [['company_id','status','number'], 'safe']
        ];        
    }
}
