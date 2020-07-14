<?php

namespace app\models\ActiveRecord\Companies;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%contacts}}".
 *
 * @property int $id
 * @property string $chief_position Дожность руководителя
 * @property string $chief_fio ФИО руководителя
 * @property string $chief_phone Телефон руководителя
 * @property string $chief_email Email руководителя
 * @property string $manager_position Должность менеджера
 * @property string $manager_fio ФИО менеджера
 * @property string $manager_phone Телефон менеджера
 * @property string $manager_fax Факс менеджера
 * @property string $manager_email Email менеджера
 *
 * @property Company $company
 */
class Contact extends ActiveRecord
{
    
    const BASE_COMPANY = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contacts}}';
    }

    /**
     * 
     * @param string $chiefPosition
     * @param string $chiefFio
     * @param string $chiefPhone
     * @param string $chiefEmail
     * @param string $managerPosition
     * @param string $managerFio
     * @param string $managerPhone
     * @param string $managerEmail
     * @param string $managerFax
     * @return \self
     */
    public static function create(
            string $chiefPosition,
            string $chiefFio,
            string $chiefPhone,
            string $chiefEmail,
            string $managerPosition,
            string $managerFio,
            string $managerPhone,
            string $managerEmail,
            string $managerFax = ''
            ):self
    {
        $contact = new self();
        $contact->chief_position = $chiefPosition;
        $contact->chief_fio = $chiefFio;
        $contact->chief_email = $chiefEmail;
        $contact->chief_phone = $chiefPhone;
        
        $contact->manager_position = $managerPosition;
        $contact->manager_fio = $managerFio;
        $contact->manager_email = $managerEmail;        
        $contact->manager_phone = $managerPhone;
        $contact->manager_fax = $managerFax;
        return $contact;
    }
    
    /**
     * 
     * @param string $chiefPosition
     * @param string $chiefFio
     * @param string $chiefPhone
     * @param string $chiefEmail
     * @param string $managerPosition
     * @param string $managerFio
     * @param string $managerPhone
     * @param string $managerEmail
     * @param string $managerFax
     */
    public function edit(
            string $chiefPosition,
            string $chiefFio,
            string $chiefPhone,
            string $chiefEmail,
            string $managerPosition,
            string $managerFio,
            string $managerPhone,
            string $managerEmail,
            string $managerFax = ''            
            )
    {
        $this->chief_position = $chiefPosition;
        $this->chief_fio = $chiefFio;
        $this->chief_email = $chiefEmail;
        $this->chief_phone = $chiefPhone;
 
        $this->manager_position = $managerPosition;
        $this->manager_fio = $managerFio;
        $this->manager_email = $managerEmail;        
        $this->manager_phone = $managerPhone;
        $this->manager_fax = $managerFax;        
    }

    /**
     * Gets query for [[Company]].
     *
     * @return ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class(), ['contacts_id' => 'id']);
    }
}
