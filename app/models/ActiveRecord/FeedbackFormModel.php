<?php

namespace app\models\ActiveRecord;

use app\models\ActiveRecord\Users\User;
use app\models\CreatedTimestampTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%feedback_form}}".
 *
 * @property int $id
 * @property int $user_id Id пользователя
 * @property string|null $message
 * @property int $created_at
 *
 * @property Users $user
 */
class FeedbackFormModel extends ActiveRecord
{
    use CreatedTimestampTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%feedback_form}}';
    }
    
    /**
     * 
     * @param int $userId
     * @param string $message
     * @return self
     */
    public static function create(int $userId, string $message): self
    {
        $model = new self();
        $model->user_id = $userId;
        $model->message = $message;
        return $model;
        
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
