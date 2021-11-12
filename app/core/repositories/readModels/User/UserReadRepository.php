<?php

namespace app\core\repositories\readModels\User;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\core\traits\ActiveRecord\GetProviderTrait;
use app\models\ActiveRecord\Users\User;
use yii\data\DataProviderInterface;

/**
 * Description of UserRepository
 *
 * @author kotov
 */
class UserReadRepository implements ReadRepositoryInterface
{
    use GetProviderTrait;
    
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
                ->andWhere(['deleted' => false])
                ->one();
    }
    public function findByAuthKey($authKey):? User
    {
        return User::find()
                ->where(['auth_key' => $authKey])
                ->andWhere(['deleted' => false])              
                ->one();
    }  
    
    public function getAllMembers(): DataProviderInterface 
    {        
        $query = User::find()->members();
        $provider = $this->getProvider($query);
        $provider->setPagination(false);
        return $provider;
    }
}
