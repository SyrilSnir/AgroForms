<?php

namespace app\models\ActiveRecord\Exhibition;

use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\Forms\Manage\Exhibition\CatalogForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catalog".
 *
 * @property int $id
 * @property int|null $exhibition_id Выставка
 * @property string|null $logo_file Файл логотипа
 * @property string|null $company Компания
 * @property string|null $company_eng Компания (ENG)
 * @property string|null $country Страна
 * @property string|null $country_eng Страна (ENG)
 * @property string|null $description Описание
 * @property string|null $description_eng Описание (ENG)
 *
 * @property CatalogRubrics[] $catalogRubrics
 * @property Exhibitions $exhibition
 * @property Rubricator[] $rubrics
 */
class Catalog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog';
    }
    
    public static function create(CatalogForm $form): self
    {
        $model = new self();
        $model->exhibition_id = $form->exhibitionId;
        $model->company = $form->company;
        $model->company_eng = $form->companyEng;
        $model->description = $form->description;
        $model->description_eng = $form->descriptionEng;
        $model->country = $form->country;
        $model->country_eng = $form->countryEng;
        return $model;
    }
    
    public function edit(CatalogForm $form): void
    {        
        $this->exhibition_id = $form->exhibitionId;
        $this->company = $form->company;
        $this->company_eng = $form->companyEng;
        $this->description = $form->description;
        $this->description_eng = $form->descriptionEng;
        $this->country = $form->country;
        $this->country_eng = $form->countryEng;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exhibition_id'], 'integer'],
            [['description', 'description_eng'], 'string'],
            [['logo_file', 'company', 'company_eng', 'country', 'country_eng'], 'string', 'max' => 255],
            [['exhibition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibitions::class, 'targetAttribute' => ['exhibition_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exhibition_id' => 'Exhibition ID',
            'logo_file' => 'Logo File',
            'company' => 'Company',
            'company_eng' => 'Company Eng',
            'country' => 'Country',
            'country_eng' => 'Country Eng',
            'description' => 'Description',
            'description_eng' => 'Description Eng',
        ];
    }

    /**
     * Gets query for [[CatalogRubrics]].
     *
     * @return ActiveQuery
     */
    public function getCatalogRubrics()
    {
        return $this->hasMany(CatalogRubrics::class, ['catalog_id' => 'id']);
    }

    /**
     * Gets query for [[Exhibition]].
     *
     * @return ActiveQuery
     */
    public function getExhibition()
    {
        return $this->hasOne(Exhibitions::class, ['id' => 'exhibition_id']);
    }

    /**
     * Gets query for [[Rubrics]].
     *
     * @return ActiveQuery
     */
    public function getRubrics()
    {
        return $this->hasMany(Rubricator::class, ['id' => 'rubric_id'])->viaTable('catalog_rubrics', ['catalog_id' => 'id']);
    }
}
