<?php

namespace app\core\repositories\manage\Users;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Users\ManagerRoleRules;
use yii\db\ActiveRecord;

/**
 * Description of ManagerRoleRulesRepository
 *
 * @author kotov
 */
class ManagerRoleRulesRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = ManagerRoleRules::findOne($id)) {
            throw new NotFoundException('Правило не найдено');
        }
        return $model;
    }
}
