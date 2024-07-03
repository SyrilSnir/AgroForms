<?php

namespace app\core\repositories\readModels\User;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Users\ManagerRoles;

/**
 * Description of ManagerRoleReadRepository
 *
 * @author kotov
 */
class ManagerRoleReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return ManagerRoles::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
