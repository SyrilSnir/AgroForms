<?php

namespace app\core\services\operations\Requests;

use app\core\repositories\manage\Requests\AttacmentFileRepository;
use app\models\ActiveRecord\Requests\AttachedFiles;
use app\models\Forms\Requests\RemoveAttachmentForm;
use yii\web\UploadedFile;

/**
 * Description of AttachedFilesService
 *
 * @author kotov
 */
class AttachedFilesService
{
    /**
     * 
     * @var AttacmentFileRepository
     */
    protected $repository;
    
    public function __construct(AttacmentFileRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function create(int $requestId, int $fieldId, UploadedFile $file) :AttachedFiles
    {
        $attached = AttachedFiles::create($requestId, $fieldId, $file);
        $this->repository->save($attached);
        return $attached;
    }
    
    public function remove(RemoveAttachmentForm $form) 
    {
        /** @var AttachedFiles $attached */
        $attachedList = AttachedFiles::find()
                ->andWhere(['request_id' => $form->requestId ])
                ->andWhere(['field_id' => $form->fieldId])
                ->all();
        foreach ($attachedList as $attached) 
        {
            $attached->configureFileUploadParameters();
            $attached->delete();
        }
        
    }
}
