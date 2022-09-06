<?php

namespace app\models\ActiveRecord\Document;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Document\Query\DocumentQuery;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\CreatedTimestampTrait;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%documents}}".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string|null $title_eng Заголовок (ENG)
 * @property string|null $description Описание
 * @property string|null $description_eng Описание (ENG)
 * @property string $file Файл
 * @property int $exhibition_id Выставка
 * @property int $company_id Компания
 * @property int $created_at Дата добавления
 * 
 * @property Company $company
 * @property Exhibition $exhibition
 * 
 * @method string|null getUploadedFileUrl(string $attribute) Получить Url загруженного файла
 * @method string getUploadedFilePath(string $attribute) Получить путь к загруженному файлу
 * 
 */
class Documents extends ActiveRecord
{
    use CreatedTimestampTrait, MultilangTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%documents}}';
    }
    
    public static function create(
            string $title,
            string $titleEng,
            string $description,
            string $descriptionEng,
            int $exhibitionId,
            int $companyId = null
            ) :self
    {
        $document = new self();
        $document->title = $title;
        $document->title_eng = $titleEng;
        $document->description = $description;
        $document->description_eng = $descriptionEng;
        $document->company_id = $companyId;
        $document->exhibition_id = $exhibitionId;
        return $document;
    }    
    
    public function __construct($config = []) {
        parent::__construct($config);
        $documentPath = Yii::getAlias('@documentsUploadPath');
        $documentUrl = Yii::getAlias('@documentsUploadUrl');
        $this->attachBehavior('documentUploadBehavior', [
                'class' => FileUploadBehavior::class,
                'attribute' => 'file',
                'filePath' => $documentPath . '/[[attribute_exhibition_id]]/[[attribute_company_id]]/[[pk]]-[[filename]].[[extension]]',
                'fileUrl' => $documentUrl . '/[[attribute_exhibition_id]]/[[attribute_company_id]]/[[pk]]-[[filename]].[[extension]]',
            ]);
    }
    
    public function edit(
            string $title,
            string $titleEng,
            string $description,
            string $descriptionEng,
            int $exhibitionId,
            int $companyId = null
            ) :void
    { 
        $this->title = $title;
        $this->title_eng = $titleEng;
        $this->description = $description;
        $this->description_eng = $descriptionEng;
        $this->company_id = $companyId;
        $this->exhibition_id = $exhibitionId;        
    }   

    /**
     * Gets query for [[Company]].
     *
     * @return ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }
    
    public function setFile(UploadedFile $file) 
    {
        $this->file = $file;
    }

    /**
     * Gets query for [[Exhibition]].
     *
     * @return ActiveQuery
     */
    public function getExhibition()
    {
        return $this->hasOne(Exhibition::class, ['id' => 'exhibition_id']);
    }
    
    /**
     * 
     * @return DocumentQuery
     */
    public static function find() 
    {
        return new DocumentQuery(static::class);
    }
}