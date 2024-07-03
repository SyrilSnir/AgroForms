<?php

namespace app\core\repositories\readModels\User;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Users\ManagerRoleRules;

/**
 * Description of ManagerRoleRulesReadRepository
 *
 * @author kotov
 */
class ManagerRoleRulesReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return ManagerRoleRules::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
