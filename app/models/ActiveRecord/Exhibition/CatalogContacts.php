<?php

namespace app\models\ActiveRecord\Exhibition;

use Yii;

/**
 * This is the model class for table "catalog_contacts".
 *
 * @property int $id
 * @property int $catalog_id Запись в каталоге
 * @property string|null $site Сайт
 * @property string|null $email Email
 * @property string|null $phone Телефон
 *
 * @property Catalog $catalog
 */
class CatalogContacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog_contacts';
    }
    
    public static function create(
            int $catalogId,
            string $site = '',
            string $email = '',
            string $phone =''
    ):self 
    {
        $model = new self();
        $model->catalog_id = $catalogId;
        $model->site = $site;
        $model->email = $email;
        $model->phone = $phone;
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_id'], 'required'],
            [['catalog_id'], 'integer'],
            [['site', 'email', 'phone'], 'string', 'max' => 255],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::class, 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_id' => 'Catalog ID',
            'site' => 'Site',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }

    /**
     * Gets query for [[Catalog]].
     *
     * @return \yii\db\ActiveQuery[]
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }
}
