<?php

namespace app\core\repositories\manage\Users;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Users\ManagerRoles;
use yii\db\ActiveRecord;

/**
 * Description of ManagerRoleRepository
 *
 * @author kotov
 */
class ManagerRoleRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = ManagerRoles::findOne($id)) {
            throw new NotFoundException('Роль не найдена');
        }
        return $model;
    }
}
