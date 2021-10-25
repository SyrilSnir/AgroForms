<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\Lists\GetFormsListTrait;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Forms\Stand;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
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
    
    public $formId;


    use GetFormsListTrait;
    
    public function __construct(Stand $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->description = $model->description;
            $this->nameEng = $model->name_eng;
            $this->descriptionEng = $model->description_eng;
            $this->price = $model->price;
            $this->imageFile = $model->image_url;
            $this->formId = $model->form_id;
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
            [['price','formId'], 'required'],
            [['price','formId'], 'integer'],
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
            'formId' => Yii::t('app', 'Form'),
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

    public function formsList():array
    {
        $stand = Form::find()->with('exhibition')->andWhere(['form_type_id' => FormType::SPECIAL_STAND_FORM])->orderBy('id')->all();
        return ArrayHelper::map($stand, 'id', function($model) {
            return $model->name . ' (' . $model->exhibition->title .  ')';
        });         
    }    
}

