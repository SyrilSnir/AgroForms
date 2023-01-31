<?php

namespace app\models\SearchModels\Contracts;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetExhibitionsTrait;
use app\core\traits\Lists\GetHallsListTrait;
use app\core\traits\Lists\GetStandNumbersListTrait;
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
    
    public $exhibition_id;
    
    public $status;
    
    public $hall_id;
    
    public $stand_number_id;


    use GetCompanyNamesTrait, GetExhibitionsTrait, GetHallsListTrait, GetStandNumbersListTrait;
    
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
        $query->andFilterWhere(['exhibition_id' => $this->exhibition_id]);
        $query->andFilterWhere(['hall_id' => $this->hall_id]);
        $query->andFilterWhere(['stand_number_id' => $this->stand_number_id]);
        $query->andFilterWhere(['like','number', $this->number]);  
        $query->andFilterWhere(['status' => $this->status]);  
        return $dataProvider;        
    }

    public function rules(): array
    {
        return [
            [['company_id','exhibition_id','status','number','hall_id','stand_number_id'], 'safe']
        ];        
    }   
}
