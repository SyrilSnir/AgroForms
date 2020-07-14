<?php

namespace app\models\ActiveRecord\Companies;

use yii\db\ActiveQuery;

/**
 * Description of LegalAddress
 *
 * @author kotov
 */
class LegalAddress extends Address
{
    const BASE_COMPANY = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%legal_addresses}}';
    }

    /**
     * Gets query for [[Company]].
     *
     * @return ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasMany(Company::class, ['legal_address_id' => 'id']);
    }    
}
