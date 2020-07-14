<?php

namespace app\models\SearchModels\Users;

use app\models\ActiveRecord\Users\UserType;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of UserTypeSearch
 *
 * @author kotov
 */
class UserTypeSearch extends Model
{
    public $name; 
    
    public $slug;


    public function rules(): array
    {
        return [
            [['name', 'slug'], 'safe'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = UserType::find();
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
        $query->andFilterWhere(['like','name', $this->name]);
        $query->andFilterWhere(['like','slug', $this->slug]);
        return $dataProvider;
    }
}
