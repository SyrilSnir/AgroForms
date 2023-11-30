<?php

namespace app\models\ActiveRecord\Users;

use app\core\traits\ActiveRecord\MultilangTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_types}}".
 *
 * @property int $id
 * @property string $name Название типа пользователя
 * @property string $name_eng Название типа пользователя (ENG)
 * @property string $slug Идентификатор типа пользователя
 *
 * @property User[] $users
 */
class UserType extends ActiveRecord
{
    use MultilangTrait;
    /**
     * ID для типа учетной записи "Суперпользователь"
     */
    const ROOT_USER_ID = 1;
    
    /**
     * Роль суперадминистратора
     */
    const SUPER_ADMIN = 'superadmin';
    
    /**
     * Роль "администратор"
     */
    const ROOT_USER_TYPE = 'admin';
    
    const MEMBER_USER_ID = 2;
    const MEMBER_USER_TYPE = 'member';
    
    /**
     * Менеджер
     */
    const MANAGER_USER_ID = 3;
    const MANAGER_USER_TYPE = 'manager';
    
    /**
     * Бухгалтер
     */
    const ACCOUNTANT_USER_ID = 4;
    const ACCOUNTANT_USER_TYPE = 'accountant';
    
    const ORGANIZER_USER_ID = 5;
    const ORGANIZER_USER_TYPE = 'organizer';
    
    const MEDIA_MANAGER_USER_ID = 6;
    const MEDIA_MANAGER_USER_TYPE = 'media-manager';
    
    const ROLES = [
        self::ROOT_USER_ID => self::ROOT_USER_TYPE,
        self::MEMBER_USER_ID => self::MEMBER_USER_TYPE,
        self::ORGANIZER_USER_ID => self::ORGANIZER_USER_TYPE,
        self::MANAGER_USER_ID => self::MANAGER_USER_TYPE,
        self::ACCOUNTANT_USER_ID => self::ACCOUNTANT_USER_TYPE,
        self::MEDIA_MANAGER_USER_ID => self::MEDIA_MANAGER_USER_TYPE,
    ];    
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
    
    /**
     * 
     * @param string $name
     * @param string $nameEng
     */
    public function setName( string $name, string $nameEng ='') 
    {
        $this->name = $name;
        $this->name_eng = $nameEng;
    }        
}
