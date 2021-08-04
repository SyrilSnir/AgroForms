<?php

namespace app\models\SearchModels\Companies;

use app\models\ActiveRecord\Companies\Company;
use app\models\SearchModels\SearchInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of CompanySearch
 *
 * @author kotov
 */
class CompanySearch extends Model implements SearchInterface
{
    public $name; 
    
    public $full_name;    

    public function rules(): array
    {
        return [
            [['name', 'full_name'], 'safe'],
        ];
    }
    public function search(array $params): ActiveDataProvider
    {
        $query = Company::find();
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
        $query->andFilterWhere(['like','full_name', $this->full_name]);
        return $dataProvider;
    }
}
