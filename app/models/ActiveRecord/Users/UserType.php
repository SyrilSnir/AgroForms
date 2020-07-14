<?php

namespace app\models\ActiveRecord\Users;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_types}}".
 *
 * @property int $id
 * @property string $name Название типа пользователя
 * @property string $slug Идентификатор типа пользователя
 *
 * @property User[] $users
 */
class UserType extends ActiveRecord
{
    /**
     * ID для типа учетной записи "Суперпользователь"
     */
    const ROOT_USER_ID = 1;
    /**
     * Роль "администратор"
     */
    const ROOT_USER_TYPE = 'admin';
    
    const MEMBER_USER_ID = 2;
    const MEMBER_USER_TYPE = 'member';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_types}}';
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_type_id' => 'id']);
    }
    
    public function setName( string $name) 
    {
        $this->name = $name;
    }
}
