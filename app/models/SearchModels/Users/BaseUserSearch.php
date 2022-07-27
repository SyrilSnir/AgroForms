<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\SearchModels\Users;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\models\ActiveRecord\Users\queries\UserQuery;
use app\models\ActiveRecord\Users\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of BaseUserSearch
 *
 * @author kotov
 */
class BaseUserSearch extends Model
{
    public $login; 
    
    public $fio;
    
    public $email;
    
    public $company_id;  

    use GetCompanyNamesTrait;
    
    public function rules(): array
    {
        return [
            [['login', 'fio','email'], 'safe'],  
            [['company_id'], 'integer']
        ];
    }
    
    public function search(array $params): ActiveDataProvider
    {
        $query = User::find();
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
        $this->addFilters($query);

        return $dataProvider;
    }   
    
    protected function addFilters(UserQuery $query) 
    {
        $query->andFilterWhere(['deleted' => false]);
        $query->andFilterWhere(['company_id' => $this->company_id]);    
        $query->andFilterWhere(['like','login', $this->login]);
        $query->andFilterWhere(['like','fio', $this->fio]);
        $query->andFilterWhere(['like','email', $this->email]);        
    }
}
