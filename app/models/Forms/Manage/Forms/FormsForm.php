<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\Lists\GetExhibitionsTrait;
use app\core\traits\Lists\GetFormTypesListTrait;
use app\core\traits\Lists\GetValutesListTrait;
use app\models\ActiveRecord\Forms\Form;
use app\models\Validators\PublishedValidator;
use Yii;
use yii\base\Model;

/**
 * Description of FormsForm
 *
 * @author kotov
 */
class FormsForm extends Model
{
    public $id;
    
    public $title;
    public $name;
    public $slug;
    public $description;
    public $formType;
    public $order;
    public $basePrice;
    public $hasFile;
    public $valute;
    public $exhibitionId; 
    public $published;


    public $nameEng;
    public $titleEng;
    public $descriptionEng;
    
   
    use GetExhibitionsTrait, GetValutesListTrait, GetFormTypesListTrait;



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
           $this->published = $model->published;
           $this->exhibitionId = $model->exhibition_id;
           $this->valute = $model->valute_id;
           $this->id = $model->id;
       }
       parent::__construct($config);
   }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'],'safe'],
            [['title', 'name', 'slug', 'formType'], 'required'],
            [['order', 'formType','basePrice','valute','exhibitionId'],'integer'],
            [['hasFile','published'],'boolean'],
            [['order','basePrice'],'default','value' => 0],
            [['title', 'name', 'slug', 'description','titleEng', 'nameEng', 'descriptionEng'], 'string', 'max' => 255],
            /*['published', PublishedValidator::class],*/  // Снимаем ограничение на публикацию одной формы
        ];
    } 
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app','Name'),
            'titleEng' => Yii::t('app','Name') . ' (ENG)',
            'name' => Yii::t('app','Title'),
            'nameEng' => Yii::t('app','Title') . ' (ENG)',
            'slug' => Yii::t('app','Character code'),
            'description' => Yii::t('app','Description'),
            'descriptionEng' => Yii::t('app','Description') . ' (ENG)',
            'formType' => Yii::t('app/requests','Form type'),
            'order' => Yii::t('app','Serial number'),
            'basePrice' => Yii::t('app/requests','Base price'),
            'hasFile' => Yii::t('app','File attachment available'),
            'published' => Yii::t('app','Available for publication on the site'),
            'exhibitionId' => Yii::t('app','Available for exhibitions'),
            'valute' => Yii::t('app','Valute'),
        ];
    }   
}
