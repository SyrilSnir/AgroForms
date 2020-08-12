<?php

namespace app\models\ActiveRecord\Exhibition;

use Yii;

/**
 * This is the model class for table "{{%exhibitions}}".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string|null $title_eng Заголовок (ENG)
 * @property string|null $description Описание
 * @property string|null $description_eng Описание (ENG)
 * @property int $start_date Дата начала
 * @property int $end_date Дата окончания
 * @property int $status Статус
 */
class Exhibition extends \yii\db\ActiveRecord
{
    
    public static function create(
            string $title,
            string $title_eng,
            string $description ,
            string $description_eng,
            string $startDate,
            string $endDate
            ):self
    {
        $exhibition = new self();
        $exhibition->title = $title;
        $exhibition->title_eng = $title_eng;
        $exhibition->description = $description;
        $exhibition->description_eng = $description_eng;
        $exhibition->start_date = $startDate;
        $exhibition->end_date = $endDate;
        return $exhibition;
    }
    
    public function edit(
            string $title,
            string $title_eng,
            string $description ,
            string $description_eng,
            string $startDate,
            string $endDate
            )
    {
        $this->title = $title;
        $this->title_eng = $title_eng;
        $this->description = $description;
        $this->description_eng = $description_eng;
        $this->start_date = $startDate;
        $this->end_date = $endDate;        
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%exhibitions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'title_eng' => 'Заголовок (ENG)',
            'description' => 'Описание',
            'description_eng' => 'Описание (ENG)',
            'start_date' => 'Дата начала',
            'end_date' => 'Дата окончания',
            'status' => 'Статус',
        ];
    }
}
