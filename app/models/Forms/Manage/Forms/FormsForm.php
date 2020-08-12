<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\Lists\GetExhibitionsTrait;
use app\core\traits\Lists\GetValutesListTrait;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Description of FormsForm
 *
 * @author kotov
 */
class FormsForm extends Model
{
    public $title;
    public $name;
    public $slug;
    public $description;
    public $formType;
    public $order;
    public $basePrice;
    public $hasFile;
    public $valute;

    public $nameEng;
    public $titleEng;
    public $descriptionEng;
    
    /**
     *
     * @var array
     */
    public $exhibitionsList;
    
    use GetExhibitionsTrait, GetValutesListTrait;



    public function __construct(Form $model = null, $config = array())
   {
       if ($model) {
           $this->title = $model->title;
           $this->name = $model->name;
           $this->description = $model->description;
           $this->order = $model->order;
           $this->formType = $model->form_type_id;
           $this->slug = $model->slug;
           $this->basePrice = $model->base_price;
           $this->nameEng = $model->name_eng;
           $this->titleEng = $model->title_eng;
           $this->descriptionEng = $model->description_eng;
           $this->hasFile = $model->has_file;
           $this->exhibitionsList = $model->exhibitions;
           $this->valute = $model->valute_id;
       }
       parent::__construct($config);
   }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'name', 'slug', 'formType'], 'required'],
            [['order', 'formType','basePrice','valute'],'integer'],
            [['hasFile'],'boolean'],
            [['order','basePrice'],'default','value' => 0],
            [['title', 'name', 'slug', 'description','titleEng', 'nameEng', 'descriptionEng'], 'string', 'max' => 255],
            [['exhibitionsList'],'each', 'rule' => ['integer']],
        ];
    } 
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'titleEng' => 'Название (ENG)',
            'name' => 'Заголовок',
            'nameEng' => 'Заголовок (ENG)',
            'slug' => 'Символьный код',
            'description' => 'Описание',
            'descriptionEng' => 'Описание (ENG)',
            'formType' => 'Тип формы',
            'order' => 'Порядковый номер',
            'basePrice' => 'Базовая стоимость',
            'hasFile' => 'Доступно вложение файла',
            'exhibitionsList' => 'Доступна для выставок',
            'valute' => 'Валюта'
        ];
    }
    
    public function formTypesList():array
    {
        return ArrayHelper::map(FormType::find()->where(['!=','id', FormType::SPECIAL_STAND_FORM])->orderBy('id')->asArray()->all(),'id','name');
    }
}
