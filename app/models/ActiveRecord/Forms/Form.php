<?php

namespace app\models\ActiveRecord\Forms;

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
 * @property int $base_price Базовая стоимость
 * @property int $form_type_id Id типа формы
 * 
 * @property string $headerName Заголовок
 * 
 * @property FormType $formType Тип формы
 */
class Form extends ActiveRecord
{
    use TimestampTrait;
    use AddSlugTrait;
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
        $form->description_eng = $descriptionEng;
        
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
            int $basePrice            
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
    }
    
    public function getFormType() : ActiveQuery
    {
        return $this->hasOne(FormType::class, ['id' => 'form_type_id']);
    }
    
    public function getHeaderName() :string
    {
        return $this->title . ' : ' . mb_convert_case($this->name, MB_CASE_UPPER);
    }
}