<?php

namespace app\models\SearchModels\Nomenclature;

use app\models\ActiveRecord\Nomenclature\EquipmentPrices;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of EquipmentPricesSearch
 *
 * @author kotov
 */
class EquipmentPricesSearch extends Model
{
    /**
     * 
     * @var int
     */
    private $equipmentId; 
    
    public $exhibitionId;
    
    public function __construct(int $equipmentId, $config = [])
    {
        $this->equipmentId = $equipmentId;
        parent::__construct($config);       
    }
    
    public function search(array $params = []): ActiveDataProvider
    {
        $query = EquipmentPrices::find()->andWhere(['equipment_id' => $this->equipmentId]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['exhibition_id' => SORT_ASC]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['exhibition_id' => $this->exhibitionId]);
        return $dataProvider;
    } 
    
    public function rules(): array
    {
        return [
            [['exhibition_id'], 'safe'],
        ];
    }      
}
