<?php

namespace app\core\repositories\manage\Users\Profile;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Users\Profile\MemberProfile;
use yii\db\ActiveRecord;

/**
 * Description of MemberProfileRepository
 *
 * @author kotov
 */
class MemberProfileRepository implements RepositoryInterface
{
    use DataManipulationTrait;
 
    public function get(int $id): ActiveRecord
    {
        if (!$model = MemberProfile::find()->andWhere(['user_id' => $id])
                ->one()) {
            throw new NotFoundException('Профиль не найден');
        }
        return $model;
    }
}
