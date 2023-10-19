<?php

namespace app\core\repositories\readModels\Requests;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Requests\AttachedFiles;

/**
 * Description of AttachedFilesReadRepository
 *
 * @author kotov
 */
class AttachedFilesReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return AttachedFiles::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * 
     * @param int $fieldId
     * @return AttachedFiles[]
     */
    public static function findByFieldId(int $fieldId)
    {
        return AttachedFiles::find()
            ->andWhere(['field_id' => $fieldId])
            ->all();
    }
    
    /**
     * 
     * @param int $fieldId
     * @param int $requestId
     * @return AttachedFiles[]
     */
    public static function findByFieldAndRequest(int $fieldId,int $requestId)
    {
        return AttachedFiles::find()
            ->andWhere(['field_id' => $fieldId])
            ->andWhere(['request_id' => $requestId])
            ->all();
    }    
}
