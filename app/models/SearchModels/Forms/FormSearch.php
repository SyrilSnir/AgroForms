<?php

namespace app\models\SearchModels\Forms;

use app\core\traits\Lists\GetExhibitionsTrait;
use app\models\ActiveRecord\Forms\Form;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of FormSearch
 *
 * @author kotov
 */
class FormSearch extends Model
{
    public $name;
    
    public $title;
    
    public $status;
    
    public $exhibitionId;
    
    public $published;

    use GetExhibitionsTrait;
    public function rules(): array
    {
        return [
            [['name','published' ,'title', 'status','exhibitionId'], 'safe'],
        ];
    }    
    public function search(array $params): ActiveDataProvider
    {
        $query = Form::find()->actual();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like','name', $this->name]);
        $query->andFilterWhere(['like','title', $this->title]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['published' => $this->published]);
        $query->andFilterWhere(['exhibition_id' => $this->exhibitionId]);
        $query->orderBy('order');
        return $dataProvider;
    }
}
