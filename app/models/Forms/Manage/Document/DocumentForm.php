<?php


namespace app\models\Forms\Manage\Document;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetExhibitionsTrait;
use app\models\ActiveRecord\Document\Documents;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Description of DocumentForm
 *
 * @author kotov
 */
class DocumentForm extends Model
{
    public $title;
    public $titleEng;
    public $description;
    public $descriptionEng;
    public $companyId;
    public $exhibitionId;
    public $file;
    public $fileUrl;


    use GetCompanyNamesTrait, GetExhibitionsTrait;

    public function __construct(Documents $model = null, $config = []) 
    {
        parent::__construct($config);
        if ($model) {
            $this->companyId = $model->company_id;
            $this->exhibitionId = $model->exhibition_id;
            $this->title = $model->title;
            $this->titleEng = $model->title_eng;
            $this->description = $model->description;
            $this->descriptionEng = $model->description_eng;
            $this->fileUrl = $model->getUploadedFileUrl('file');
        }
    }  
    
    public function beforeValidate() :bool
    {
        if(parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['description','title','titleEng','descriptionEng'], 'string'],
            [['companyId','exhibitionId'], 'required'],
            [['file'],'file'],
            [['fileUrl'],'safe']
        ];
    }
    
    public function attributeLabels(): array 
    {
        return [
            'title' => Yii::t('app', 'Title'), 
            'titleEng' => Yii::t('app', 'Title') . ' (ENG)', 
            'description' => Yii::t('app', 'Description'),  
            'descriptionEng' => Yii::t('app', 'Description') . ' (ENG)',            
            'companyId' => t('Company','company'),
            'exhibitionId' => t('Exhibition'),  
            'file' => t('Attached file')
        ];
    }    
}
