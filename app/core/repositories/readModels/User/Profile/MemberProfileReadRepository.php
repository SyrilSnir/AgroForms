<?php

namespace app\core\repositories\readModels\User\Profile;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Users\Profile\MemberProfile;

/**
 * Description of MemberProfileReadRepository
 *
 * @author kotov
 */
class MemberProfileReadRepository implements ReadRepositoryInterface
{
    
    public static function findById($id): ?MemberProfile
    {
        return MemberProfile::find()
                ->andWhere(['user_id' => $id])
                ->one();
    }
}
