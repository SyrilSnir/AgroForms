<?php

namespace app\models\SearchModels\Users;

use app\models\ActiveRecord\Users\ManagerRoles;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of ManagerRoleSearch
 *
 * @author kotov
 */
class ManagerRoleSearch extends Model
{
    public $name;
    
    public function rules(): array
    {
        return [
            [['name'], 'safe'],
        ];
    }    
    
    public function search(array $params): ActiveDataProvider
    {
        $query = ManagerRoles::find();
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
        $query->orFilterWhere(['like','name', $this->name])
              ->orFilterWhere(['like','name_eng', $this->name]);
        return $dataProvider;
    }    
}
