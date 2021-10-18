<?php

namespace app\models\Forms\Manage\Exhibition;

use app\core\helpers\Utils\DateHelper;
use app\core\traits\Lists\GetCompanyNamesTrait;
use app\models\ActiveRecord\Exhibition\Exhibition;
use Yii;
use yii\base\Model;

/**
 * Description of ExhibitionForm
 *
 * @author kotov
 */
class ExhibitionForm extends Model
{
    public $title;
    public $titleEng;
    public $description;
    public $descriptionEng;
    public $startDate;
    public $endDate;
    public $status;
    public $startAssembling;
    public $endAssembling;
    public $startDisassembling;
    public $endDisassembling;
    public $companyId;
    public $address;
    
    use GetCompanyNamesTrait;
    
    public function __construct(Exhibition $model = null, $config = array())
    {              
        parent::__construct($config);
        if ($model) {           
            $this->title = $model->title;
            $this->titleEng = $model->title_eng;
            $this->description = $model->description;
            $this->descriptionEng = $model->description_eng;
            $this->startDate = DateHelper::timestampToDate($model->start_date);
            $this->endDate = DateHelper::timestampToDate($model->end_date);
            $this->startAssembling = DateHelper::timestampToDate($model->assembling_start);
            $this->endAssembling = DateHelper::timestampToDate($model->assembling_end);
            $this->startDisassembling = DateHelper::timestampToDate($model->disassembling_start);
            $this->endDisassembling = DateHelper::timestampToDate($model->disassembling_end);
            $this->companyId = $model->company_id;
            $this->address = $model->address;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'startDate', 'endDate','status','companyId'], 'required'],
            [['startDate', 'endDate','startAssembling','endAssembling','startDisassembling','endDisassembling'], 'date'],
            [['title', 'titleEng', 'description', 'descriptionEng','address'], 'string', 'max' => 255],
            [['titleEng', 'description', 'descriptionEng'], 'default', 'value' => ''],
        ];
    }  

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app','Title'),
            'titleEng' => Yii::t('app','Title') . ' (ENG)',
            'description' => Yii::t('app','Description'),
            'descriptionEng' => Yii::t('app','Description') . ' (ENG)',
            'startDate' => Yii::t('app','Start date'),
            'endDate' => Yii::t('app','End date'),
            'status' => Yii::t('app','Status'),
            'startAssembling' => Yii::t('app','Start date of assembling'),
            'endAssembling' => Yii::t('app','End date of assembling'),
            'startDisassembling' => Yii::t('app','Start date of disassembling'),
            'endDisassembling' => Yii::t('app','End date of disassembling'),
            'address' => Yii::t('app','Location'),
            'companyId' => t('Organizer', 'exhibitions'),
            'status' => Yii::t('app','Status')
        ];        
    }    
}
