<?php

namespace app\models\SearchModels\Documents;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetExhibitionsTrait;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Description of DocumentSearch
 *
 * @author kotov
 */
class ManagerDocumentSearch extends BaseDocumentSearch
{
    public $company_id;  
    
    public $exhibition_id;
    
    use GetCompanyNamesTrait, GetExhibitionsTrait;
    
    public function search(array $params = []): ActiveDataProvider   
    {
        $dataProvider = parent::search($params);        
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $dataProvider->query->andFilterWhere(['company_id' => $this->company_id]);   
        $dataProvider->query->andFilterWhere(['exhibition_id' => $this->exhibition_id]);        
        return $dataProvider;
    }

    public function rules(): array
    {
        $baseRules = parent::rules();
        return ArrayHelper::merge($baseRules,
                [
                    [['company_id','exhibition_id'], 'safe']
        ]);        
    }    
}
