<?php

namespace app\models\SearchModels\Users;

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


    use GetUserTypeListTrait;
    
    public function rules(): array
    {
        return [
            [['login', 'fio'], 'safe'],
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
        $query->andFilterWhere(['like','login', $this->login]);
        $query->andFilterWhere(['like','fio', $this->fio]);
        return $dataProvider;
    }
}
