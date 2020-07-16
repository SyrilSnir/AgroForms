<?php

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\Stand;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * 
 * 
 * 
 */
class StandForm extends Model
{ 
    public $name;
    
    public $description;
    
    public $price;

    public $imageFile;
    
    public $photo;


    public function __construct(Stand $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->description = $model->description;
            $this->price = $model->price;
            $this->imageFile = $model->image_url;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['description', 'string'],
            [['price'], 'required'],
            [['price'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['imageFile','photo'], 'image'],
        ];
    }
    
        /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'photo' => 'Имя оригинального файла с изображением',
            'image_path' => 'Путь к файлу с изображением',
            'image_url' => 'Url файла с изображением',
            'plan_path' => 'Путь к файлу с планом стенда',
            'price' => 'Цена за м2'
        ];
    }
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }    
}

