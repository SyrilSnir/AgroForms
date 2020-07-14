<?php

namespace app\core\repositories\readModels\Requests;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Requests\RequestDynamicForm;

/**
 * Description of RequestDynamicFormReadRepository
 *
 * @author kotov
 */
class RequestDynamicFormReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return RequestDynamicForm::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
    
    public static function findByRequest($requestId)
    {
        return RequestDynamicForm::find($requestId)
            ->andWhere(['request_id' => $requestId])
            ->one();
    }
}
