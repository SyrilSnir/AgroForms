<?php

namespace app\models\ActiveRecord\Exhibition;

use Yii;

/**
 * This is the model class for table "catalog_rubrics".
 *
 * @property int $catalog_id Запись в каталоге
 * @property int $rubric_id ID рубрики
 *
 * @property Catalog $catalog
 * @property Rubricator $rubric
 */
class CatalogRubrics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog_rubrics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_id', 'rubric_id'], 'required'],
            [['catalog_id', 'rubric_id'], 'integer'],
            [['catalog_id', 'rubric_id'], 'unique', 'targetAttribute' => ['catalog_id', 'rubric_id']],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::class, 'targetAttribute' => ['catalog_id' => 'id']],
            [['rubric_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rubricator::class, 'targetAttribute' => ['rubric_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_id' => 'Catalog ID',
            'rubric_id' => 'Rubric ID',
        ];
    }

    /**
     * Gets query for [[Catalog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }

    /**
     * Gets query for [[Rubric]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRubric()
    {
        return $this->hasOne(Rubricator::class, ['id' => 'rubric_id']);
    }
}
