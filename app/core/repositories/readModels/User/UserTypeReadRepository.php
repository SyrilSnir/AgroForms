<?php

namespace app\core\repositories\readModels\User;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Users\UserType;


/**
 * Description of UserTypeReadRepository
 *
 * @author kotov
 */
class UserTypeReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return UserType::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
