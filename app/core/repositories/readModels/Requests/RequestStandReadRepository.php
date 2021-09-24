<?php

namespace app\core\repositories\readModels\Requests;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\core\traits\ActiveRecord\GetProviderTrait;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestStand;
use yii\data\DataProviderInterface;

/**
 * Description of RequestStandReadRepository
 *
 * @author kotov
 */
class RequestStandReadRepository implements ReadRepositoryInterface
{
    use GetProviderTrait;
    
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
    
    public function getActiveStands() : DataProviderInterface
    {
        $query = Request::find()->forStands()->andWhere(['NOT IN','status', [BaseRequest::STATUS_DRAFT, BaseRequest::STATUS_DELETE]]);      
        $provider = $this->getProvider($query);
        $provider->setPagination(false);
        return $provider;
    }
}
