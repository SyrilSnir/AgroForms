<?php

namespace app\models\ActiveRecord\Forms;

use app\core\traits\ActiveRecord\MultilangTrait;
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
 * @property string|null $name_eng Название (ENG)
 * @property string|null $description_eng Описание (ENG)
 * @property string|null $photo Имя оригинального файла с изображением
 * @property string|null $image_path Путь к файлу с изображением
 * @property string|null $image_url Url файла с изображением
 * @property string|null $plan_path Путь к файлу с планом стенда
 * @property int $price Цена за м2
 */
class Stand extends ActiveRecord
{

    use MultilangTrait;
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
    
    /**
     * 
     * @param string $name
     * @param string $description
     * @param string $nameEng
     * @param string $descriptionEng
     * @param int $price
     * @return \self
     */
    public static function create(
            string $name,
            string $description,
            string $nameEng,
            string $descriptionEng,
            int $price
            ): self
    {
        $stand = new self();
        $stand->name = $name;
        $stand->description = $description;
        $stand->name_eng = $nameEng;
        $stand->description_eng = $descriptionEng;
        $stand->price = $price;
        return $stand;
    }

    /**
     * 
     * @param string $name
     * @param string $description
     * @param string $nameEng
     * @param string $descriptionEng
     * @param int $price
     * @return void
     */
    public function edit(
            string $name,
            string $description,
            string $nameEng,
            string $descriptionEng,            
            int $price   
            ):void
    {
        $this->name = $name;
        $this->description = $description;
        $this->name_eng = $nameEng;
        $this->description_eng = $descriptionEng;
        $this->price = $price;       
    }

    public function setPhoto(UploadedFile $photo): void
    {
        $this->photo = $photo;
    }   


}
