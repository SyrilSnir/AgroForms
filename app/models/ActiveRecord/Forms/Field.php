<?php

namespace app\models\ActiveRecord\Forms;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\Forms\Manage\Forms\FieldParametersForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%fields}}".
 *
 * @property int $id
 * @property string|null $name Название
 * @property string|null $description Описание
 * @property string|null $name_eng Название (ENG)
 * @property string|null $description_eng Описание (ENG)
 * @property int $form_id Форма
 * @property int $element_type_id Тип элемента формы
 * @property int $field_group_id Группа
 * @property int $order Позиция на экране
 * @property string|null $default_value Значение по умолчанию
 * @property string|null $parameters Параметры
 * 
 * @property ElementType $elementType Тип элемента
 * @property FieldGroup $fieldGroup Позиция на экране
 * @property Form $form Форма
 * @property FieldEnum[] $enums Перечисляемые аттрибуты
 * @property FieldParametersForm $fieldParams Параметры
 */
class Field extends ActiveRecord
{

    use MultilangTrait;
/**
 * 
 * @param string $name
 * @param string $description
 * @param string $nameEng
 * @param string $descriptionEng
 * @param int $formId
 * @param int $elementTypeId
 * @param int $order
 * @param string $defaultValue
 * @param string $parameters
 * @return \self
 */    
    public static function create(
            string $name,
            string $description,
            string $nameEng,
            string $descriptionEng,            
            int $formId,
            int $elementTypeId,
            int $fieldGroupId,
            int $order,
            string $defaultValue = '',
            string $parameters = ''     
            ):self
    {
        $model = new self();
        $model->name = $name;
        $model->description = $description;
        $model->name_eng = $nameEng;
        $model->description_eng = $descriptionEng;
        $model->form_id = $formId;
        $model->element_type_id = $elementTypeId;
        $model->field_group_id = $fieldGroupId;
        $model->order = $order;
        $model->parameters = $parameters;
        $model->default_value = $defaultValue;
        
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fields}}';
    }
/**
 * 
 * @param string $name
 * @param string $description
 * @param string $nameEng
 * @param string $descriptionEng
 * @param int $formId
 * @param int $elementTypeId
 * @param int $order
 * @param string $defaultValue
 * @param string $parameters
 */    
    public function edit(
            string $name,
            string $description,
            string $nameEng,
            string $descriptionEng,            
            int $formId,
            int $elementTypeId,
            int $fieldGroupId,            
            int $order,
            string $defaultValue = '',
            string $parameters = ''              
            )
    {
        $this->name = $name;
        $this->description = $description;
        $this->name_eng = $nameEng;
        $this->description_eng = $descriptionEng;
        $this->form_id = $formId;
        $this->element_type_id = $elementTypeId;
        $this->field_group_id = $fieldGroupId;
        $this->order = $order;
        $this->parameters = $parameters;
        $this->default_value = $defaultValue;        
    }

    public function getElementType()
    {
        return $this->hasOne(ElementType::class, ['id' => 'element_type_id']);
    }
    
    public function getFieldGroup()
    {
        return $this->hasOne(FieldGroup::class, ['id' => 'field_group_id']);
    }

    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }
    
    public function getEnums()
    {
        return $this->hasMany(FieldEnum::class, ['field_id' => 'id']);
    }
    
    public function hasEnums():bool
    {
        return in_array($this->element_type_id, ElementType::HAS_ENUM_ATTRIBUTES);
    }

    public function getFieldParams(): FieldParametersForm
    {
        $params = json_decode($this->parameters, true);
        $form = new FieldParametersForm();
        $form->setAttributes($params);
        return $form;
    }
}
