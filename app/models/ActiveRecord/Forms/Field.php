<?php

namespace app\models\ActiveRecord\Forms;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\core\traits\FieldParametersTrait;
use app\models\ActiveRecord\Forms\Query\FieldQuery;
use app\models\Forms\Manage\Forms\Parameters\BaseParametersForm;
use DateTime;
use yii\db\ActiveRecord;
use function GuzzleHttp\json_decode;

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
 * @property int $label_id Метка поля
 * @property int $order Позиция на экране
 * @property boolean $showed_in_request Отображать в заявке
 * @property boolean $showed_in_pdf Отображать в печатной форме
 * @property boolean $to_export Добавлять в выгрузку
 * @property boolean $published Может быть опубликовано на сайте
 * @property string|null $default_value Значение по умолчанию
 * @property string|null $parameters Параметры
 * @property bool $deleted Флаг удаления
 * @property string|null $deleted_at Дата удаления
 * @property ElementType $elementType Тип элемента
 * @property FieldGroup $fieldGroup Позиция на экране
 * @property Form $form Форма
 * @property FieldLabels|null $label Метка
 * @property FieldEnum[] $enums Перечисляемые аттрибуты
 * @property BaseParametersForm $fieldParams Параметры
 * 
 * @property int|null $price Цена
 * @property SpecialPrice|null $actualSpecialPrice Действующая специальная цена
 */
class Field extends ActiveRecord
{

    use MultilangTrait, FieldParametersTrait;
  
/**
 * 
 * @param string $name
 * @param string $description
 * @param string $nameEng
 * @param string $descriptionEng
 * @param int $formId
 * @param int $elementTypeId
 * @param bool $showInRequest
 * @param bool $showInPdf
 * @param bool $toExport
 * @param bool $published
 * @param int $fieldGroupId
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
            bool $showInRequest,
            bool $showInPdf,
            bool $toExport,
            bool $published = false,
            ?int $labelId = null,
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
        $model->showed_in_request = $showInRequest;
        $model->showed_in_pdf = $showInPdf;        
        $model->to_export = $toExport;
        $model->published = $published;
        $model->label_id = $labelId;
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
 * @param int $fieldGroupId
 * @param int $order
 * @param bool $showInRequest
 * @param bool $showInPdf
 * @param bool $toExport 
 * @param bool $published
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
            bool $showInRequest,            
            bool $showInPdf,
            bool $toExport,
            bool $published = false,
            ?int $labelId = null,
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
        $this->showed_in_request = $showInRequest;
        $this->showed_in_pdf = $showInPdf;
        $this->to_export = $toExport;
        $this->parameters = $parameters;
        $this->default_value = $defaultValue;   
        $this->label_id = $labelId;
        $this->published = $published;
    }

    public function getElementType()
    {
        return $this->hasOne(ElementType::class, ['id' => 'element_type_id']);
    }
    
    public function getFieldGroup()
    {
        return $this->hasOne(FieldGroup::class, ['id' => 'field_group_id']);
    }
    
    public function getLabel()
    {
        return $this->hasOne(FieldLabels::class, ['id' => 'label_id']);
    }    

    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }
    
    public function getEnums()
    {
        return $this->hasMany(FieldEnum::class, ['field_id' => 'id'])->orderBy(['order' => SORT_ASC])->indexBy('id');
    }
    
    public function hasEnums():bool
    {
        return in_array($this->element_type_id, ElementType::HAS_ENUM_ATTRIBUTES);
    }

    public function getFieldParams(): BaseParametersForm
    {
        $params = json_decode($this->parameters, true);
        $form = $this->getParametersForm($this->element_type_id,$this);
        $form->setAttributes($params, false);
        return $form;
    }
    /**
     * Цена
     * @return int|null
     */
    public function getPrice(): ?int 
    {
        if (!$this->fieldParams->isComputed) {
            return null;
        }   
        if (empty($this->fieldParams->unitPrice)) {
            return 0;
        }
        //return  $this->actualSpecialPrice ? (int) $this->actualSpecialPrice->price : (int) $this->fieldParams->unitPrice;
        return $this->fieldParams->unitPrice;
    }
    
    public function getActualSpecialPrice(): ?SpecialPrice
    {
        $currentDate = ( new DateTime())->format('Y-m-d');        
        return SpecialPrice::find()
                ->andWhere(['field_id' => $this->id])
                ->andWhere(['<','start_date',$currentDate])
                ->andWhere(['>','end_date',$currentDate])
                ->one();        
    }
    /**
     * 
     * @return Field[]
     */
    public function getFieldsInGroup()
    {
        return Field::find()
                ->andWhere(['field_group_id' => $this->id])
                ->orderBy('order')
                ->all();
    }

    public static function find(): FieldQuery
    {
        return new FieldQuery(static::class);
    }    
}
