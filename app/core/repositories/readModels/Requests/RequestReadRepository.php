<?php

namespace app\core\repositories\readModels\Requests;

use app\core\repositories\readModels\ReadRepositoryInterface;
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
        return Request::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
