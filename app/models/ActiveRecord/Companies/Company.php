<?php

namespace app\models\ActiveRecord\Companies;

use app\models\ActiveRecord\Contract\Contracts;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%companies}}".
 *
 * @property int $id
 * @property string $name Название
 * @property string $full_name Полное наименование
 * @property string $inn ИНН
 * @property string $kpp КПП
 * @property string $phone Телефон
 * @property string $fax Факс
 * @property string $site Сайт
 * @property int $contacts_id Контакты
 * @property int $bank_details_id Банковские реквизиты
 * @property int $postal_address_id Почтовый адрес
 * @property int $legal_address_id Юридический адрес
 * @property string|null $image_path Путь к файлу с изображением
 * @property string|null $image_url Url файла с изображением
 * @property bool $deleted
 * @property bool $blocked
 *
 * @property User $member
 * 
 * @property BankDetail $bankDetails
 * @property Contact $contacts
 * @property LegalAddress $legalAddress
 * @property PostalAddress $postalAddress
 */
class Company extends ActiveRecord
{
    
    const BASE_COMPANY = 1;
    /**
     * {@inheritdoc}
     */
        
    public static function tableName()
    {
        return '{{%companies}}';
    }
    
    public function behaviors(): array
    {
        return [
                   [
                    'class' => SaveRelationsBehavior::className(),
                    'relations' => ['bankDetails', 'contacts', 'postalAddress', 'legalAddress'],
                    ]
        ];
    }
/**
 * 
 * @param string $name
 * @param string $fullName
 * @param string $inn
 * @param string $kpp
 * @param string $phone
 * @param string $site
 * @param string $fax
 * @param BankDetail $bankDetails
 * @param Contact $contacts
 * @param LegalAddress $legalAddress
 * @param PostalAddress $postalAddress
 * @return \self
 */
    public static function create(
            string $name,
            string $fullName,
            string $inn,
            string $kpp,
            string $phone,
            string $site,
            string $fax,
        BankDetail $bankDetails,
           Contact $contacts,
      LegalAddress $legalAddress,
     PostalAddress $postalAddress                        
            ): self
    {
        $company = new self();
        $company->name = $name;
        $company->full_name = $fullName;
        $company->inn = $inn;
        $company->kpp = $kpp;
        $company->phone = $phone;
        $company->site = $site;
        $company->fax = $fax;
        $company->bankDetails = $bankDetails;
        $company->contacts = $contacts;
        $company->postalAddress = $postalAddress;
        $company->legalAddress = $legalAddress;
        return $company;
    }
    /**
     * 
     * @param string $name
     * @param string $fullName
     * @param string $inn
     * @param string $kpp
     * @param string $phone
     * @param string $site
     * @param string $fax
     * @param BankDetail $bankDetails
     * @param Contact $contacts
     * @param LegalAddress $legalAddress
     * @param PostalAddress $postalAddress
     */
    public function edit(
            string $name,
            string $fullName,
            string $inn,
            string $kpp,
            string $phone,
            string $site,
            string $fax,
        BankDetail $bankDetails,
           Contact $contacts,
      LegalAddress $legalAddress,
     PostalAddress $postalAddress            
        )
    {
        $this->name = $name;
        $this->full_name = $fullName;
        $this->inn = $inn;
        $this->kpp = $kpp;
        $this->phone = $phone;
        $this->site = $site;
        $this->fax = $fax; 
        $this->bankDetails = $bankDetails;
        $this->contacts = $contacts;
        $this->postalAddress = $postalAddress;
        $this->legalAddress = $legalAddress;        
    }

    /**
     * Gets query for [[BankDetail]].
     *
     * @return ActiveQuery
     */
    public function getBankDetails()
    {
        return $this->hasOne(BankDetail::className(), ['id' => 'bank_details_id']);
    }

    /**
     * Gets query for [[Contact]].
     *
     * @return ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasOne(Contact::class, ['id' => 'contacts_id']);
    }

    /**
     * Gets query for [[Contracts]].
     *
     * @return ActiveQuery
     */    
    public function getContracts()
    {
        return $this->hasMany(Contracts::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[LegalAddress]].
     *
     * @return ActiveQuery
     */
    public function getLegalAddress()
    {
        return $this->hasOne(LegalAddress::className(), ['id' => 'legal_address_id']);
    }

    /**
     * Gets query for [[PostalAddress]].
     *
     * @return ActiveQuery
     */
    public function getPostalAddress()
    {
        return $this->hasOne(PostalAddress::className(), ['id' => 'postal_address_id']);
    }
    
    public function isBlocked(): bool 
    {
        return $this->blocked;
    }
       
    
    public function block() :self
    {
        $this->blocked = true;  
        return $this;
    }
    
    public function unblock() :self
    {
        $this->blocked = false;
        return $this;
    }
    
    /**
     * Возвращает пользователя, являющегося участником выставки для данной компании
     * 
     * @return User|null
     */
    public function getMember(): ?User
    {
       return User::findOne([
           'deleted' => false, 
           'user_type_id' => UserType::MEMBER_USER_ID,
           'company_id' => $this->id
        ]); 
    }
    
    public function getAvailableExhibitions()
    {
        return Exhibition::find()->
                joinWith('contracts')->
                andWhere(['contracts.company_id' => $this->id])->
                andWhere(['contracts.status' => Contracts::STATUS_ACTIVE])->
                orderBy(['end_date' => SORT_DESC])->
                all();
    }
    
    public function deleteCompany()
    {
        $this->deleted = true;
    }
}
