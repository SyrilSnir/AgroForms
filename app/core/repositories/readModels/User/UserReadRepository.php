<?php

namespace app\core\repositories\readModels\User;

use app\models\ActiveRecord\Users\User;
use app\core\repositories\readModels\ReadRepositoryInterface;

/**
 * Description of UserRepository
 *
 * @author kotov
 */
class UserReadRepository implements ReadRepositoryInterface
{
    
    public static function findById($id): ?User
    {
        return User::find()
                ->andWhere(['id' => $id])
         //      ->andWhere(['active' => User::STATUS_ACTIVE])
                ->one();
    }
    public function findByLogin($value):? User
    {
        return User::find()
                ->where(['active' => User::STATUS_ACTIVE])
                ->andWhere(['login' => $value])              
                ->one();
    }
    public function findByAuthKey($authKey):? User
    {
        return User::find()
                ->where(['auth_key' => $authKey])
                ->andWhere(['deleted' => false])              
                ->one();
    }    
}
