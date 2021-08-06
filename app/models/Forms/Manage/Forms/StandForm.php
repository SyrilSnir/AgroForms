<?php

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\Stand;
use Yii;
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
    
    public $nameEng;
    
    public $descriptionEng;    
    
    public $price;

    public $imageFile;
    
    public $photo;


    public function __construct(Stand $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->description = $model->description;
            $this->nameEng = $model->name_eng;
            $this->descriptionEng = $model->description_eng;
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
            [['description','nameEng','descriptionEng'], 'string'],
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
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'nameEng' => Yii::t('app', 'Name') . ' (ENG)',
            'descriptionEng' => Yii::t('app', 'Description') . ' (ENG)',            
            'photo' => Yii::t('app','The name of the original image file'),
            'image_path' => 'Путь к файлу с изображением',
            'image_url' => 'Url файла с изображением',
            'plan_path' => 'Путь к файлу с планом стенда',
            'price' => Yii::t('app', 'Price for, m<sup>2</sup>'),
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

