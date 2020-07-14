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
    
    public function searchForUser(int $userId, array $params = []) 
    {
        return $this->search($params, $userId);
    }
    
    public function searchForManager(array $params = [])
    {
        $dp = $this->search($params);
        $dp->query->andFilterWhere(['!=', 'status', Request::STATUS_DRAFT]);
        return$dp ;
    }

    public function searchAll(array $params = [])
    {
        return $this->search($params);
    }

    private function search(array $params = [], $userId = null): ActiveDataProvider
    {
        $query = Request::find();
        if ($userId) {
            $query->forUser($userId);
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
