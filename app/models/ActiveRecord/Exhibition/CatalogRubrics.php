<?php

namespace app\models\ActiveRecord\Exhibition;

use app\models\ActiveRecord\Nomenclature\Rubricator;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catalog_rubrics".
 *
 * @property int $catalog_id Запись в каталоге
 * @property int $rubric_id ID рубрики
 *
 * @property Catalog $catalog
 * @property Rubricator $rubric
 */
class CatalogRubrics extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog_rubrics';
    }
    
    public static function create(int $catalogId, int $rubricId):self
    {
        $model = new self();
        $model->catalog_id = $catalogId;
        $model->rubric_id = $rubricId;
        return $model;
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
     * @return ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }

    /**
     * Gets query for [[Rubric]].
     *
     * @return ActiveQuery
     */
    public function getRubric()
    {
        return $this->hasOne(Rubricator::class, ['id' => 'rubric_id']);
    }
}
