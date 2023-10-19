<?php

namespace app\models\ActiveRecord\Exhibition;

use app\models\ActiveRecord\Geography\Country;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catalog_countries".
 *
 * @property int $catalog_id Запись в каталоге
 * @property int $country_id ID страны
 *
 * @property Catalog $catalog
 * @property Countries $country
 */
class CatalogCountries extends ActiveRecord
{
            
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog_countries';
    }

    public static function create(int $catalogId,int $coutryId): self
    {
        $model = new self();
        $model->catalog_id = $catalogId;
        $model->country_id = $coutryId;
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
        return $this->hasOne(Countries::class, ['id' => 'country_id']);
    }
}
