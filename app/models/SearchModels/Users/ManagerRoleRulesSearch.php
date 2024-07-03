<?php

namespace app\models\SearchModels\Users;

use app\models\ActiveRecord\Users\ManagerRoleRules;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of ManagerRoleRulesSearch
 *
 * @author kotov
 */
class ManagerRoleRulesSearch extends Model
{
    public $form_id;
    
    public $role_id;
    
    public function rules(): array
    {
        return [
            [['form_id', 'role_id'], 'safe'],
        ];
    }    
    
    public function search(array $params): ActiveDataProvider
    {
        $query = ManagerRoleRules::find();
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
        $query->orFilterWhere(['role_id' => $this->role_id])
              ->orFilterWhere(['form_id' => $this->form_id]);
        return $dataProvider;
    } 
}
