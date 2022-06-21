<?php

namespace app\models\Forms\Manage\Document;

use app\models\ActiveRecord\Document\Documents;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Description of BaseDocumentForm
 *
 * @author kotov
 */
class BaseDocumentForm extends Model
{
    public $title;
    public $titleEng;
    public $description;
    public $descriptionEng;
    public $exhibitionId;
    public $companyId;
    public $file;
    public $fileUrl;
    
    public function __construct(Documents $model = null, $config = []) 
    {
        parent::__construct($config);
        if ($model) {
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
