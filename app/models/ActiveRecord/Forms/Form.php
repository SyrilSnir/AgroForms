<?php

namespace app\models\ActiveRecord\Forms;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\ActiveRecord\Common\Valute;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\AddSlugTrait;
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
 * @property boolean $has_file Может содержать вложенный файл
 * @property int $base_price Базовая стоимость
 * @property int $form_type_id Id типа формы
 * @property int $valute_id Id валюты
 * 
 * @property string $headerName Заголовок
 * 
 * @property FormType $formType Тип формы
 * @property Valute $valute Валюта
 * @property FormExhibitions[] $formExhibitions Выставки
 * @property Exhibition[] $exhibitions Выставки
 * 
 */
class Form extends ActiveRecord
{
    use TimestampTrait, AddSlugTrait, MultilangTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%forms}}';
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
 * @param int $created
 * @return \self
 */
    public static function create(
            string $title,
            string $name,
            string $description,
            string $slug,
            string $titleEng,
            string $nameEng,
            string $descriptionEng,            
            int $formTypeId,
            int $order,
            int $basePrice,
            bool $hasFile,
            int $valute = Valute::RUB,
            int $created = null
            ):self
    {
        $form = new self();
        $form->name = $name;
        $form->title = $title;
        $form->description = $description;
        $form->slug = $slug;
        $form->form_type_id = $formTypeId;
        $form->order = $order;
        $form->created_by = $created;
        $form->base_price = $basePrice;
        $form->name_eng = $nameEng;
        $form->title_eng = $titleEng;
        $form->has_file = $hasFile;
        $form->description_eng = $descriptionEng;
        $form->valute_id = $valute;
        
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
    public function edit(
            string $title,
            string $name,
            string $description,
            string $slug,
            string $titleEng,
            string $nameEng,
            string $descriptionEng,             
            int $formTypeId,
            int $order,
            int $basePrice,
            bool $hasFile,
            int $valute = Valute::RUB
            )
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->slug = $slug;
        $this->form_type_id = $formTypeId;
        $this->title_eng = $titleEng;
        $this->name_eng = $nameEng;
        $this->description_eng = $descriptionEng;
        $this->base_price = $basePrice;
        $this->order = $order;
        $this->has_file = $hasFile;
        $this->valute_id = $valute;
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
    
    public function getFormExhibitions()
    {
        return $this->hasMany(FormExhibitions::class, ['forms_id' => 'id']);
    }
    
    public function getExhibitions()
    {
        return $this->hasMany(Exhibition::class, ['id' => 'exhibitions_id'])
                ->via('formExhibitions');
    }       
}