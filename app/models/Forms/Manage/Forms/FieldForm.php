<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\Lists\GetFieldGroupTrait;
use app\core\traits\Lists\GetFormsListTrait;
use app\core\traits\Lists\GetUnitsTrait;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\Forms\MultiForm;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of FieldForm
 *
  * @property FieldParametersForm $parameters
 * @author kotov
 */
class FieldForm extends MultiForm
{
    public $id;
    
    public $name;
    public $description;
    public $nameEng;
    public $descriptionEng;    
    public $formId;
    public $elementTypeId;
    public $fieldGroupId;
    public $order;
    public $defaultValue;
    
    
    
    
    /**
     *
     * @var bool
     */
    public $hasEnums = false;
    
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
            $this->id = $model->id;
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
            $this->hasEnums = $model->hasEnums();
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
            [['order','fieldGroupId'], 'default','value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'nameEng' => Yii::t('app', 'Name') . ' (ENG)',
            'descriptionEng' => Yii::t('app', 'Description') . ' (ENG)',            
            'formId' => Yii::t('app', 'Form'),
            'elementTypeId' => Yii::t('app', 'Element type'),
            'fieldGroupId' => Yii::t('app', 'Field group'),
            'order' => Yii::t('app', 'Position'),
            'defaultValue' => Yii::t('app', 'Default falue'),
        ];
    }
 
    public function elementTypesList():array
    {
        $notAvailable =[
            ElementType::ELEMENT_DATE,
            ElementType::ELEMENT_DATE_MULTIPLE,
            ElementType::ELEMENT_GROUP
        ];
        return ArrayHelper::map(ElementType::find()->where(['NOT IN', 'id',$notAvailable])->orderBy('id')->asArray()->all(),'id','name');       
    }

    protected function internalForms(): array
    {
        return ['parameters'];        
    }

}
