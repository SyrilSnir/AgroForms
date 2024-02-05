<?php

namespace app\models\SearchModels\Contracts;

use app\models\ActiveRecord\Contract\ContractMediaFees;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of ContractMediaFeeSearch
 *
 * @author kotov
 */
class ContractMediaFeeSearch  extends Model
{  
    /**
     * 
     * @var int
     */
    private $contractId;
    
    public function __construct(int $contractId, $config = []) 
    {
        $this->contractId = $contractId;
        parent::__construct($config);
    }
    
    public function search(): ActiveDataProvider   
    {
        $query = ContractMediaFees::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                //'defaultOrder' => ['order' => SORT_ASC]
            ]
        ]);  
        $query->andFilterWhere(['contract_id' => $this->contractId]);
        return $dataProvider;        
    }
}
