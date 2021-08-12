<?php

namespace app\models\ActiveRecord\Users\queries;

use app\models\ActiveRecord\Users\UserType;
use yii\db\ActiveQuery;

/**
 * Description of UserQuery
 *
 * @author kotov
 */
class UserQuery extends ActiveQuery
{
    public function members(string $alias = null) :self
    {
        return $this->andWhere([
           ($alias ? $alias . '.' : '') . 'user_type_id'  => UserType::MEMBER_USER_ID
        ]);
    }
}
