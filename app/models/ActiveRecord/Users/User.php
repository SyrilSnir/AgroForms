<?php

namespace app\models\ActiveRecord\Users;

use app\core\helpers\Utils\users\RolesHelper;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Users\Profile\DefaultProfile;
use app\models\ActiveRecord\Users\Profile\MemberProfile;
use app\models\ActiveRecord\Users\Profile\UserProfileInterface;
use app\models\ActiveRecord\Users\queries\UserQuery;
use app\models\Data\Operations;
use app\models\TimestampTrait;
use DateTime;
use Yii;
use yii\db\ActiveQuery;
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
 * @property int $role_id Id роли менеджера
 * @property int $gender Пол
 * @property int $language Язык
 * @property UserProfileInterface $profile Профиль
 * @property string|null $fio ФИО
 * @property string|null $position ФИО
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
 * @property ManagerRoles $role
 * 
 */
class User extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;
    
     use TimestampTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }
    
    public static function find(): UserQuery
    {
        return new UserQuery(static::class);
    }

        /**
     * 
     * @param int $id ID
     * @param string $login
     * @param int $userTypeId
     * @param int $companyId
     * @param string $fio
     * @param string $email
     * @param string $phone
     * @param string $birthday
     * @param string $position
     * @param int $gender
     * @param int $language
     * @param int $role
     * @return \self
     */
    public static function create(
            string $login,
            int $userTypeId,
            int $companyId,
            string $fio,
            string $email,
            string $phone,
            string $birthday,
            string $position,
            int $gender,
            int $language,
            int $role = null
            ):self
    {
        $user = new User();
        $user->login = $login;
        $user->user_type_id = $userTypeId;
        if ($userTypeId === UserType::MANAGER_USER_ID) {
            $user->role_id = $role;
        }
        $user->company_id = $companyId;
        $user->fio = $fio;
        $user->email = $email;
        $user->phone = $phone;
        if ($user->birthday) {
            $user->birthday = DateTime::createFromFormat('d.m.Y',$birthday)->format('Y-m-d');
        }
        $user->language = $language;
        $user->gender = $gender;
        $user->position = $position;
        $user->active = self::STATUS_NEW;
        return $user;  
    }
     
    /**
     * 
     * @param string $login
     * @param int $userTypeId
     * @param int $companyId
     * @param string $fio
     * @param string $email
     * @param string $phone
     * @param string $birthday
     * @param string $position
     * @param int $gender
     * @param int $language
     */
    public function edit(
            string $login,
            int $userTypeId,
            int $companyId,
            string $fio,
            string $email,
            string $phone,
            string $birthday,
            string $position,
            int $gender,
            int $language,
            int $role = null
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
        if ($userTypeId === UserType::MANAGER_USER_ID) {
            $this->role_id = $role;
        }        
        $this->language = $language;
        $this->gender = $gender;
        //$this->active = self::STATUS_NEW;    
        $this->position = $position;
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
                $profile = new MemberProfile();
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
    
    public function restoreUser()
    {
        $this->deleted = false;
    }

    public function block() 
    {
        $this->active = static::STATUS_BLOCKED;
    }
    
    public function unblock() 
    {
        $this->active = static::STATUS_ACTIVE;
    }

    public function getName(): string 
    {
        $nameArray = explode(' ', $this->fio);
        $cnt = count($nameArray);
        if (empty($cnt)) {
            return '';
        }
        return ($cnt == 1) ? $nameArray[0] : $nameArray[1];
    }
    
    public function getMiddleName(): string 
    {
        $nameArray = explode(' ', $this->fio);        
        return count($nameArray) <= 2 ? '' : $nameArray[2];
    }
    
    public function getSurName(): string 
    {
        $nameArray = explode(' ', $this->fio);        
        if (count($nameArray) <= 1) {
            return '';
        }
        return $nameArray[0];

    }
    /**
     * 
     * @return type
     */
    public function getRole() : ActiveQuery
    {
        return $this->hasOne(ManagerRoles::class, ['id' => 'role_id']);
    }
    
    public function canOperation(string $entity, string $operation):bool
    {        
        if (RolesHelper::isAdmin()) {
            return true;
        }
        if ($this->role && $this->user_type_id === UserType::MANAGER_USER_ID) {
            switch ($entity) {
                case Operations::ENTITY_DOCUMENT:
                    return $this->canDocumentOperations($operation);
                case Operations::ENTITY_CONTRACT:
                    return $this->canContractOperations($operation);
                case Operations::ENTITY_USER:
                    return $this->canUserOperations($operation);
                case Operations::ENTITY_COMPANY:
                    return $this->canCompanyOperations($operation);
                case Operations::ENTITY_RUBRICATOR:
                    return $this->canRubricatorOperations($operation);
                case Operations::ENTITY_CATALOG:
                    return $this->canCatalogOperations($operation);
                default :
                    return false;
            }
        }
    } 
    
    public function canRequestAccess() :bool
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->hasRequests();
    }

    private function canDocumentOperations(string $operation) :bool
    {
        switch ($operation) {
            case Operations::OP_VIEW:
                return $this->role->d_view;
            case Operations::OP_CREATE:
                return $this->role->d_create;
            case Operations::OP_EDIT:
                return $this->role->d_edit;
            case Operations::OP_DELETE:
                return $this->role->d_delete;
            default: 
                return false;
        }
    }
    private function canContractOperations(string $operation) :bool
    {
        switch ($operation) {
            case Operations::OP_VIEW:
                return $this->role->co_view;
            case Operations::OP_CREATE:
                return $this->role->co_create;
            case Operations::OP_EDIT:
                return $this->role->co_edit;
            case Operations::OP_DELETE:
                return $this->role->co_delete;
            default: 
                return false;
        }
    }
    
    private function canUserOperations(string $operation) :bool
    {
        switch ($operation) {
            case Operations::OP_VIEW:
                return $this->role->u_view;
            case Operations::OP_CREATE:
                return $this->role->u_create;
            case Operations::OP_EDIT:
                return $this->role->u_edit;
            case Operations::OP_DELETE:
                return $this->role->u_delete;
            default: 
                return false;
        }
    }
    private function canCompanyOperations(string $operation) :bool
    {
        switch ($operation) {
            case Operations::OP_VIEW:
                return $this->role->c_view;
            case Operations::OP_CREATE:
                return $this->role->c_create;
            case Operations::OP_EDIT:
                return $this->role->c_edit;
            case Operations::OP_DELETE:
                return $this->role->c_delete;
            default: 
                return false;
        }
    }
    private function canCatalogOperations(string $operation) :bool
    {
        switch ($operation) {
            case Operations::OP_VIEW:
                return $this->role->catalog_view;
            case Operations::OP_LOAD:
                return $this->role->catalog_load;
            default: 
                return false;
        }
    }
    private function canRubricatorOperations(string $operation) :bool
    {
        switch ($operation) {
            case Operations::OP_VIEW:
                return $this->role->r_view;
            case Operations::OP_CREATE:
                return $this->role->r_create;
            case Operations::OP_EDIT:
                return $this->role->r_edit;
            case Operations::OP_DELETE:
                return $this->role->r_delete;
            default: 
                return false;
        }
    }
}
