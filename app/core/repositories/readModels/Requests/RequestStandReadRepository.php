<?php

namespace app\core\repositories\readModels\Requests;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Requests\RequestStand;

/**
 * Description of RequestStandReadRepository
 *
 * @author kotov
 */
class RequestStandReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return RequestStand::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
    
    public static function findByRequest($requestId)
    {
        return RequestStand::find($requestId)
            ->andWhere(['request_id' => $requestId])
            ->one();
    }
    
    public function getActiveStands()
    {
        $query = Request::find()->joinWith('stands',true,'RIGHT JOIN');        
    }
}
