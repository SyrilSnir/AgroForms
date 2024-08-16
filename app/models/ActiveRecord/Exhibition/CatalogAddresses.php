<?php

namespace app\models\ActiveRecord\Exhibition;

use app\models\ActiveRecord\Geography\Country;
use app\models\Forms\CatalogAddressForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catalog_countries".
 *
 * @property int $catalog_id Запись в каталоге
 * @property int $country_id ID страны
 * @property string $region Регион / область
 * @property string $city Город
 * @property string $address Адрес
 * @property string $index Индекс
 * @property string $region_eng Регион / область (ENG)
 * @property string $city_eng Город (ENG)
 * @property string $address_eng Адрес (ENG)
 * @property string $zip_code Индекс (ENG)
 *
 * @property Catalog $catalog
 * @property Country $country
 */
class CatalogAddresses extends ActiveRecord
{
            
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%catalog_addresses}}';
    }

    public static function create(
            int $catalogId,
            int $coutryId,
            CatalogAddressForm $form
            ): self
    {
        $model = new self();
        $model->catalog_id = $catalogId;
        $model->country_id = $coutryId;
        $model->region = $form->area;
        $model->city = $form->city;
        $model->address = $form->address;
        $model->index = $form->index;
        $model->region_eng = $form->area_eng;
        $model->city_eng = $form->city_eng;
        $model->address_eng = $form->address_eng;
        $model->zip_code = $form->zip_code;
        return $model;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_id', 'country_id'], 'required'],
            [['catalog_id', 'country_id'], 'integer'],
            [['region', 'city','address', 'index','region_eng', 'city_eng','address_eng', 'zip_code'], 'string'],
            [['catalog_id', 'country_id'], 'unique', 'targetAttribute' => ['catalog_id', 'country_id']],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::class, 'targetAttribute' => ['catalog_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_id' => 'Catalog ID',
            'country_id' => 'Country ID',
        ];
    }

    /**
     * Gets query for [[Catalog]].
     *
     * @return ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
}