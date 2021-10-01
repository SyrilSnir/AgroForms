<?php

namespace app\models\SearchModels\Forms;

use app\core\traits\Lists\GetElementsTypeTrait;
use app\core\traits\Lists\GetFieldGroupTrait;
use app\core\traits\Lists\GetFormsListTrait;
use app\models\ActiveRecord\Forms\Field;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of FieldSearch
 *
 * @author kotov
 */
class FieldSearch extends Model
{
    use GetFieldGroupTrait;
    use GetFormsListTrait;
    use GetElementsTypeTrait;
    
    public $name;
    
    public $description;
    
    public $fieldGroupId;
    
    public $elementTypeId;

    public $formId;


    public function rules(): array
    {
        return [
            [['name', 'description'], 'safe'],
            [['fieldGroupId','formId','elementTypeId'], 'number'],
        ];
    } 
    
    public function searchForForm(int $formId, array $params) : ActiveDataProvider
    {
        $dp = $this->search($params);
        $dp->query->andFilterWhere(['form_id' => $formId]);
        return $dp;
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Field::find();
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
        $query->andFilterWhere(['like','description', $this->description]);
        $query->andFilterWhere(['field_group_id' => $this->fieldGroupId]);
        $query->andFilterWhere(['element_type_id' => $this->elementTypeId]);
        $query->andFilterWhere(['form_id' => $this->formId]);
        $query->orderBy('order');
        return $dataProvider;
    }
}
