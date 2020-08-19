<?php

namespace app\models\Forms\Manage\Exhibition;

use app\core\helpers\Utils\DateHelper;
use app\models\ActiveRecord\Exhibition\Exhibition;
use DateTime;
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
    
    public function __construct(Exhibition $model = null, $config = array())
    {        
        parent::__construct($config);
        $dtStart = new DateTime();
        $dtEnd = new DateTime();
        if ($model) {           
            $this->title = $model->title;
            $this->titleEng = $model->title_eng;
            $this->description = $model->description;
            $this->descriptionEng = $model->description_eng;
            $this->startDate = DateHelper::timestampToDate($model->start_date);
            $this->endDate = DateHelper::timestampToDate($model->end_date);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'startDate', 'endDate'], 'required'],
            [['startDate', 'endDate'], 'date'],
            [['title', 'titleEng', 'description', 'descriptionEng'], 'string', 'max' => 255],
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
            'title' => 'Заголовок',
            'titleEng' => 'Заголовок (ENG)',
            'description' => 'Описание',
            'descriptionEng' => 'Описание (ENG)',
            'startDate' => 'Дата начала',
            'endDate' => 'Дата окончания',
            'status' => 'Статус',
        ];
    }    
}
