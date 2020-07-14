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
class MemberProfile extends ActiveRecord implements UserProfileInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member_profile}}';
    }
    
    public static function create(
            int $userId,
            string $position = null,
            string $activities = null,
            string $proposalSignaturePost = null,
            string $proposalSignatureName = null
            ):self
    {
        $profile = new MemberProfile();
        $profile->user_id = $userId;
        $profile->position = $position;
        $profile->activities = $activities;
        $profile->proposal_signature_name = $proposalSignatureName;
        $profile->proposal_signature_post = $proposalSignaturePost;
        return $profile;
    }
    
    public function edit(
            string $position = null,
            string $activities = null,
            string $proposalSignaturePost = null,
            string $proposalSignatureName = null            
            )
    {
        $this->position = $position;
        $this->activities = $activities;
        $this->proposal_signature_name = $proposalSignatureName;
        $this->proposal_signature_post = $proposalSignaturePost;        
    }

    
    public function info(): string
    {
        return "Участник выставки";
    }

}
