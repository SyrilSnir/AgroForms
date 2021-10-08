<?php

namespace app\models\Forms\Manage\Forms;

use app\core\traits\Lists\GetExhibitionsTrait;
use app\core\traits\Lists\GetValutesListTrait;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

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
    public $status;

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
           $this->status = $model->status;
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
            [['title', 'name', 'slug', 'formType'], 'required'],
            [['order', 'formType','basePrice','valute','status'],'integer'],
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
            'exhibitionsList' => Yii::t('app','Available for exhibitions'),
            'valute' => Yii::t('app','Valute'),
            'status' => Yii::t('app','Status'),
        ];
    }
    
    public function formTypesList():array
    {
        return ArrayHelper::map(FormType::find()->where(['!=','id', FormType::SPECIAL_STAND_FORM])->orderBy('id')->asArray()->all(),'id','name');
    }
}
