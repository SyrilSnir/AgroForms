<?php

namespace app\core\repositories\readModels\Requests;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Requests\Application;

/**
 * Description of RequestDynamicFormReadRepository
 *
 * @author kotov
 */
class ApplicationReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Application::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
    
    public static function findByRequest($requestId)
    {
        return Application::find($requestId)
            ->andWhere(['request_id' => $requestId])
            ->one();
    }
}
