<?php

namespace app\core\repositories\readModels\Requests;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;

/**
 * Description of RequestReadRepository
 *
 * @author kotov
 */
class RequestReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Request::find()
            ->andWhere(['id' => $id])
            ->one();
    }
    
    public function findExportedRequests(int $exhibitionId)
    {
        return Request::find()
                ->andWhere(['exhibition_id' => $exhibitionId])
                ->andWhere(['status' => BaseRequest::STATUS_PUBLICATED])
                ->all();
    }
}
