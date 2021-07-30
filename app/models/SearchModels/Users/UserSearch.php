<?php

namespace app\models\SearchModels\Users;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetUserTypeListTrait;
use app\models\ActiveRecord\Users\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of UserSearch
 *
 * @author kotov
 */
class UserSearch extends Model
{
    public $login; 
    
    public $fio;
    
    public $email;
    
    public $active;
    
    public $user_type_id;
    
    public $company_id;


    use GetUserTypeListTrait;
    use GetCompanyNamesTrait;
    
    public function rules(): array
    {
        return [
            [['login', 'fio','email'], 'safe'],
            [['active','user_type_id','company_id'], 'integer'],
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
        $query->andFilterWhere(['deleted' => false]);
        $query->andFilterWhere(['active' => $this->active]);
        $query->andFilterWhere(['user_type_id' => $this->user_type_id]);
        $query->andFilterWhere(['company_id' => $this->company_id]);
        $query->andFilterWhere(['like','login', $this->login]);
        $query->andFilterWhere(['like','fio', $this->fio]);
        $query->andFilterWhere(['like','email', $this->email]);
        return $dataProvider;
    }
}
