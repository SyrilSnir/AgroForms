<?php

namespace app\models\ActiveRecord\Users\Profile;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%member_profile}}".
 *
 * @property int $user_id
 * @property string|null $position Должность
 * @property string|null $activities Сфера деятельности компании
 * @property string|null $proposal_signature_post Должность подписанта
 * @property string|null $proposal_signature_name ФИО подписанта
 */
class MemberProfile implements UserProfileInterface
{   
    public function info(): string
    {
        return "Участник выставки";
    }

}
