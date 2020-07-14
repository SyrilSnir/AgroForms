<?php

namespace app\models\ActiveRecord\Users;

use app\core\repositories\readModels\User\Profile\MemberProfileReadRepository;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Users\Profile\DefaultProfile;
use app\models\ActiveRecord\Users\Profile\UserProfileInterface;
use app\models\TimestampTrait;
use DateTime;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $login
 * @property string|null $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property int $user_type_id Тип пользователя
 * @property int $company_id Id компании
 * @property int $genre Пол
 * @property int $language Язык
 * @property UserProfileInterface $profile Профиль
 * @property string|null $fio ФИО
 * @property string|null $email Электронная почта
 * @property string|null $phone Номер телефона
 * @property string|null $birthday Дата рождения
 * @property string|null $description Дополнительная информация
 * @property int $created_at
 * @property int $updated_at
 * @property bool $active
 * @property bool $deleted
 * 
 * @property UserType $userType
 * @property Company $company
 * 
 */
class User extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;
    
     use TimestampTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }
    
    public static function create(
            string $login,
            int $userTypeId,
            int $companyId,
            string $fio,
            string $email,
            string $phone,
            string $birthday,
            int $genre,
            int $language
            ):self
    {
        $user = new User();
        $user->login = $login;
        $user->user_type_id = $userTypeId;
        $user->company_id = $companyId;
        $user->fio = $fio;
        $user->email = $email;
        $user->phone = $phone;
        if ($user->birthday) {
            $user->birthday = DateTime::createFromFormat('d.m.Y',$birthday)->format('Y-m-d');
        }
        $user->language = $language;
        $user->genre = $genre;
        $user->active = self::STATUS_NEW;
        return $user;  
    }
    
    public function edit(
            string $login,
            int $userTypeId,
            int $companyId,
            string $fio,
            string $email,
            string $phone,
            string $birthday,
            int $genre,
            int $language            
            ) 
    {
        $this->login = $login;
        $this->user_type_id = $userTypeId;
        $this->company_id = $companyId;
        $this->fio = $fio;
        $this->email = $email;
        $this->phone = $phone;
        if ($birthday) {
            $this->birthday = DateTime::createFromFormat('d.m.Y',$birthday)->format('Y-m-d');
        }
        $this->language = $language;
        $this->genre = $genre;
        $this->active = self::STATUS_NEW;        
    }

     public function setPassword($password) :self
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        return $this;
    }
    
    public function setAuthKey(): self
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
        return $this;
    }
    
    public function resetAuthKey(): self
    {
        $this->auth_key = null;
        return $this;
    }

    public function validatePassword($password):bool
    {
        if ($this->deleted) {
            return false;
        }
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public function getUserType()
    {
        return $this->hasOne(UserType::class, ['id' => 'user_type_id']);
    }
    
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }
    
    public function getProfile(): ?UserProfileInterface
    {
        switch ($this->user_type_id) {
            case UserType::MEMBER_USER_ID:
                $profile = MemberProfileReadRepository::findById($this->id);
                break;
            default :
                $profile = new DefaultProfile();
                break;
        }
        return $profile;
    }
    
    public function deleteUser()
    {
        $this->deleted = true;
    }
}
