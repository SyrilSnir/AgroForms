<?php

namespace app\models\ActiveRecord\Requests;

use app\models\ActiveRecord\Forms\Field;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "attached_files".
 *
 * @property int $id
 * @property int $request_id Заявка
 * @property int $field_id Поле формы
 * @property string $file_name Имя файла
 * @property int $type Тип вложения
 *
 * --------- Методы из поведения FileUploadBehavior ------------
 * 
 * @method string getUploadedFilePath(string $attribute) Вернуть путь к загруженному файлу
 * @method string getUploadedFileUrl(string $attribute) Вернуть URL загруженного файла
 * 
 * -------------------------------------------------------------
 * @property Field $field
 * @property Request $request
 */
class AttachedFiles extends ActiveRecord
{
    /**
     * Любые файлы
     */
    const STANDART_TYPE = 0; 
    
    const SITE_LOGO_TYPE = 1;
    
    const CATALOG_LOGO_TYPE = 2;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attached_files';
    }
    
    public static function create(int $requestId, int $fieldId,int $type, \yii\web\UploadedFile $file): self
    {
        $model = new self();
       
        $model->request_id = $requestId;
        $model->field_id = $fieldId;
        $model->file_name = $file;
        $model->type = $type;
        $model->configureFileUploadParameters();
        return $model;
    }
    
    public function behaviors(): array
    {

        return [
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'file_name',  
            ]
        ];
    }

    /**
     * Gets query for [[Field]].
     *
     * @return ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::class, ['id' => 'field_id']);
    }

    /**
     * Gets query for [[Request]].
     *
     * @return ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::class, ['id' => 'request_id']);
    }
    
    public function configureFileUploadParameters()
    {
        $attachedFilesPath = Yii::getAlias('@attachedPath'); 
        $this->filePath = $attachedFilesPath . DIRECTORY_SEPARATOR . $this->request_id . DIRECTORY_SEPARATOR . $this->field_id . DIRECTORY_SEPARATOR . '[[pk]]-[[filename]].[[extension]]';
        $this->fileUrl = "@attachedUrl/$this->request_id/$this->field_id/[[pk]]-[[filename]].[[extension]]";        
    }
}
