<?php

namespace app\models\ActiveRecord\Contract;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\Forms\Manage\Contract\HallForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "hall".
 *
 * @property int $id
 * @property string|null $name Название
 * @property string|null $name_eng Название (ENG)
 *
 * @property Contracts[] $contracts
 */
class Hall extends ActiveRecord
{
    use MultilangTrait;    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hall';
    }
    
    public static function create(HallForm $form): self
    {
        $model = new self();
        $model->name = $form->name;
        $model->name_eng = $form->nameEng;
        return $model;
    }
    
    public static function createByName(string $name): self
    {
        $model = new self();
        $model->name = $name;
        return $model;
    }

    public function edit(HallForm $form): void
    {
        $this->name = $form->name;
        $this->name_eng = $form->nameEng;
    }
    
    /**
     * Gets query for [[Contracts]].
     *
     * @return ActiveQuery
     */
    public function getContracts()
    {
        return $this->hasMany(Contracts::class, ['hall_id' => 'id']);
    }
}
