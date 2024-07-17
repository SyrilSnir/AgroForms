<?php

namespace app\core\helpers\Utils\users;

use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use Yii;

/**
 * Description of RolesHelper
 *
 * @author kotov
 */
class RolesHelper
{
    public static function getUser() : User
    {
        return Yii::$app->user->getIdentity()->getUser();        
    }

    public static function isGuest():bool 
    {
        return Yii::$app->user->isGuest;
    }
    
    public static function isAdmin() :bool 
    {
        return self::getUser()->user_type_id === UserType::ROOT_USER_ID;
    }
}
