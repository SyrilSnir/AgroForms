<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\Lists\GetFieldGroupTrait;
use app\core\traits\Lists\GetFormsListTrait;
use app\core\traits\Lists\GetUnitsTrait;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\Form;
use app\models\Forms\MultiForm;
use yii\helpers\ArrayHelper;

/**
 * Description of FieldForm
 *
  * @property FieldParametersForm $parameters
 * @author kotov
 */
class FieldForm extends MultiForm
{
    public $name;
    public $description;
    public $nameEng;
    public $descriptionEng;    
    public $formId;
    public $elementTypeId;
    public $fieldGroupId;
    public $order;
    public $defaultValue;

    use GetFieldGroupTrait;
    use GetFormsListTrait;
    use GetUnitsTrait;
    
    public function __construct(
            Field $model = null,
            $config = array()
            )
    {
        parent::__construct($config);
        if ($model)
        {
            $this->name = $model->name;
            $this->description = $model->description;
            $this->nameEng = $model->name_eng;
            $this->descriptionEng = $model->description_eng;
            $this->elementTypeId = $model->element_type_id;
            $this->fieldGroupId = $model->field_group_id;
            $this->formId = $model->form_id;
            $this->order = $model->order;
            $this->defaultValue = $model->default_value;
            $this->parameters = new FieldParametersForm($model);
        } else {
            $this->parameters = new FieldParametersForm();
        }
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['formId', 'elementTypeId', 'fieldGroupId'], 'required'],
            [['formId', 'elementTypeId', 'fieldGroupId', 'order'], 'integer'],
            [['name', 'description','nameEng', 'descriptionEng', 'defaultValue'], 'string', 'max' => 255],
            [['name', 'description','nameEng', 'descriptionEng', 'defaultValue'], 'default','value' => ''],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'nameEng' => 'Название (ENG)',
            'descriptionEng' => 'Описание (ENG)',            
            'formId' => 'Форма',
            'elementTypeId' => 'Тип элемента формы',
            'fieldGroupId' => 'Группа полей',
            'order' => 'Позиция на экране',
            'defaultValue' => 'Значение по умолчанию',
        ];
    }
 
    public function elementTypesList():array
    {
        return ArrayHelper::map(ElementType::find()->orderBy('id')->asArray()->all(),'id','name');       
    }

    protected function internalForms(): array
    {
        return ['parameters'];        
    }

}
