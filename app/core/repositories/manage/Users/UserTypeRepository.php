<?php

namespace app\core\repositories\manage\Users;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Users\UserType;
use yii\db\ActiveRecord;

/**
 * Description of UserTypeRepository
 *
 * @author kotov
 */
class UserTypeRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = UserType::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $model;
    }
}
