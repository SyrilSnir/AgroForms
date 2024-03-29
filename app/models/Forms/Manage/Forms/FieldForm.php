<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\FieldParametersTrait;
use app\core\traits\Lists\GetFieldGroupTrait;
use app\core\traits\Lists\GetFormsListTrait;
use app\core\traits\Lists\GetUnitsTrait;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\Forms\Manage\Forms\Parameters\AllParametersForm;
use app\models\Forms\Manage\Forms\Parameters\BaseParametersForm;
use app\models\Forms\MultiForm;
use app\models\Validators\FieldGroupValidator;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of FieldForm
 *
  * @property BaseParametersForm $parameters
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
    public $showInRequest;
    public $showInPdf;
    public $toExport;
    public $defaultValue;
    
    /**
     * 
     * @var bool
     */
    protected $isUpdated = false;
    
    
    
    
    /**
     *
     * @var bool
     */
    public $hasEnums = false;
    
    use GetFieldGroupTrait;
    use GetFormsListTrait;
    use GetUnitsTrait;
    use FieldParametersTrait;
    
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
            $this->showInRequest = $model->showed_in_request;
            $this->showInPdf = $model->showed_in_pdf;
            $this->toExport = $model->to_export;
           //$this->parameters = $this->getParametersForm($this->elementTypeId, $model);
            $this->hasEnums = $model->hasEnums();
            $this->isUpdated = true;
            $this->parameters = new AllParametersForm($model);
        } else {
            $this->parameters = new AllParametersForm();
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
            [['showInRequest','showInPdf','toExport'], 'boolean'],
            [['name', 'description','nameEng', 'descriptionEng', 'defaultValue'], 'string', 'max' => 255],
            [['name', 'description','nameEng', 'descriptionEng', 'defaultValue'], 'default','value' => ''],
            [['order','fieldGroupId'], 'default','value' => 0],
            ['fieldGroupId', FieldGroupValidator::class],
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
            'showInRequest' => Yii::t('app', 'Show in application'),
            'showInPdf' => Yii::t('app', 'Show in printed form'),
            'toExport' => Yii::t('app', 'Add to export'),
        ];
    }
 
    public function elementTypesList():array
    {
        return ArrayHelper::map(ElementType::find()->orderBy('id')->asArray()->all(),'id','name');       
    }
    
    public function fieldGroupsList(): array
    {
        if (!$this->formId) {
            return [];
        }
        return ArrayHelper::merge([0 => t('Not chosen')],
                ArrayHelper::map(Field::find()->orderBy('order')
                        ->andWhere(['form_id' => $this->formId])
                        ->andWhere(['element_type_id' =>ElementType::ELEMENT_GROUP])
                        ->asArray()->all(), 'id', 'name'));
    }

    protected function internalForms(): array
    {
        return ['parameters'];
    }
}
