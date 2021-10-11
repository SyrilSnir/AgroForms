<?php

namespace app\models\ActiveRecord\Forms;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\ActiveRecord\Common\Valute;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\AddSlugTrait;
use app\models\Forms\Manage\Forms\FormsForm;
use app\models\TimestampTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%forms}}".
 *
 * @property int $id
 * @property string $title Название
 * @property string $title_eng Название (ENG)
 * @property string $name Заголовок
 * @property string $name_eng Заголовок (ENG)
 * @property string $slug Символьный код
 * @property string|null $description Описание
 * @property string|null $description_eng Описание (ENG)
 * @property int|null $created_by Кем создан
 * @property int|null $created_at Дата создания
 * @property int|null $updated_at Дата модификации
 * @property int $order Порядок
 * @property int $status Статус
 * @property boolean $has_file Может содержать вложенный файл
 * @property int $base_price Базовая стоимость
 * @property int $form_type_id Id типа формы
 * @property int $exhibition_id Id выставки
 * @property int $valute_id Id валюты
 * 
 * @property string $headerName Заголовок
 * 
 * @property FormType $formType Тип формы
 * @property Valute $valute Валюта
 * @property Exhibition $exhibition Выставка, связанная с формой
 * 
 */
class Form extends ActiveRecord
{
    /**
     * Черновик
     */
    const STATUS_DRAFT = 0;
    
    /**
     * Активая
     */
    const STATUS_ACTIVE = 1;
    
    /**
     * Архив
     */
    const STATUS_ARCHIVE = 2;
    
    use TimestampTrait, AddSlugTrait, MultilangTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%forms}}';
    }
    
/**
 * @param FormsForm $form
 * @return \self
 */
    public static function create(FormsForm $form):self
    {
        $model = new self();
        $model->name = $form->name;
        $model->title = $form->title;
        $model->description = $form->description;
        $model->slug = $form->slug;
        $model->form_type_id = $form->formType;
        $model->order = $form->order;                
        $model->base_price = $form->basePrice;
        $model->name_eng = $form->nameEng;
        $model->title_eng = $form->titleEng;
        $model->has_file = $form->hasFile;
        $model->description_eng = $form->descriptionEng;        
        $model->valute_id = $form->valute;  
        $model->status = $form->status;
        $model->exhibition_id = $form->exhibitionId;
        return $form;
    }
    
/**
 * 
 * @param string $title
 * @param string $name
 * @param string $description
 * @param string $slug
 * @param string $titleEng
 * @param string $nameEng
 * @param string $descriptionEng
 * @param int $formTypeId
 * @param int $order
 * @param int $basePrice
 * @param bool $hasFile
 * @param int $valute
 */
    public function edit(FormsForm $form)            
    {
        $this->name = $form->name;
        $this->title = $form->title;
        $this->description = $form->description;
        $this->slug = $form->slug;
        $this->form_type_id = $form->formType;
        $this->order = $form->order;                
        $this->base_price = $form->basePrice;
        $this->name_eng = $form->nameEng;
        $this->title_eng = $form->titleEng;
        $this->has_file = $form->hasFile;
        $this->description_eng = $form->descriptionEng;        
        $this->valute_id = $form->valute; 
        $this->status = $form->status;
        $this->exhibition_id = $form->exhibitionId;
    }
    
    public function getFormType() : ActiveQuery
    {
        return $this->hasOne(FormType::class, ['id' => 'form_type_id']);
    }
    
    public function getHeaderName() :string
    {
        return $this->title . ' : ' . mb_convert_case($this->name, MB_CASE_UPPER);
    }
    
    public function getValute() : ActiveQuery
    {
        return $this->hasOne(Valute::class, ['id' => 'valute_id']);
    }    
    
    public function getExhibition()
    {
        return $this->hasOne(Exhibition::class, ['id' => 'exhibition_id']);
    }       
}