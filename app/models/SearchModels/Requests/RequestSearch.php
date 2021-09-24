<?php

namespace app\models\SearchModels\Requests;

use app\core\traits\Lists\GetFormTypesListTrait;
use app\models\ActiveRecord\Requests\Request;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of RequestSearch
 *
 * @author kotov
 */
class RequestSearch extends Model
{
    public $formType; 
    public $status;

    use GetFormTypesListTrait;
    
    public function rules(): array
    {
        return [
            [['formType','status'], 'safe'],
        ];
    }
    
    public function searchForUser(int $userId,int $exhibitionId = null, array $params = []) 
    {
        $dp = $this->baseSearch($params, $exhibitionId);
        $dp->query->forUser($userId);
        return $dp;
    }
    
    public function searchForManager(array $params = [])
    {
        $dp = $this->baseSearch($params);
        $dp->query->andFilterWhere(['!=', 'status', Request::STATUS_DRAFT]);
        return $dp;
    }

    public function searchAll(array $params = [])
    {
        return $this->baseSearch($params);
    }

    protected function baseSearch(array $params = [], $exhibitionId = null): ActiveDataProvider
    {
        $query = Request::find()->joinWith('applications',true,'RIGHT JOIN');
        if ($exhibitionId) {
            $query->forExhibition($exhibitionId);
        }
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
        $query->andFilterWhere(['form_type_id' => $this->formType]);
        $query->andFilterWhere(['status' => $this->status]);
        return $dataProvider;
    }
}
