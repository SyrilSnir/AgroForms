<?php

namespace app\models\ActiveRecord\Forms;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%stands_list}}".
 *
 * @property int $id
 * @property string $name Название
 * @property string|null $description Описание
 * @property string|null $photo Имя оригинального файла с изображением
 * @property string|null $image_path Путь к файлу с изображением
 * @property string|null $image_url Url файла с изображением
 * @property string|null $plan_path Путь к файлу с планом стенда
 * @property int $price Цена за м2
 * @property int $digit_price Стоимость символа
 * @property int|null $free_digits Количество бесплатных знаков
 */
class Stand extends ActiveRecord
{

    const STAND_FORM_ID = 1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stands_list}}';
    }
    
    
    public function __construct($config = array())
    {
        parent::__construct($config);
        $imagePath = Yii::getAlias('@uploadPath');
        $this->attachBehavior('imageUploadBehavior', [
            'class' => FileUploadBehavior::class,
            'attribute' => 'photo',
            'filePath' => $imagePath . DIRECTORY_SEPARATOR . '[[pk]]-stand.[[extension]]',
            'fileUrl' => '@uploadUrl/[[pk]]-stand.[[extension]]'             
        ]);
    }  
    
    public static function create(
            string $name,
            string $description,
            int $price,
            int $digitPrice,
            int $freeDigits = null
            ): self
    {
        $stand = new self();
        $stand->name = $name;
        $stand->description = $description;
        $stand->price = $price;
        $stand->free_digits = $freeDigits;
        $stand->digit_price = $digitPrice;
        return $stand;
    }

    public function edit(
            string $name,
            string $description,
            int $price,
            int $freeDigits,
            int $digitPrice = null     
            ):void
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->free_digits = $freeDigits;
        $this->digit_price = $digitPrice;        
    }

    public function setPhoto(UploadedFile $photo): void
    {
        $this->photo = $photo;
    }   


}
