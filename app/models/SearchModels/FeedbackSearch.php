<?php

namespace app\models\SearchModels;

use app\models\ActiveRecord\FeedbackFormModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of FeedbackSearch
 *
 * @author kotov
 */
class FeedbackSearch extends Model implements SearchInterface
{
   
    public $fio;
    
    public function rules(): array {
        return [
            ['fio','safe']
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = FeedbackFormModel::find()->joinWith('user');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like','fio', $this->fio]);

        return $dataProvider;        
    }

}
