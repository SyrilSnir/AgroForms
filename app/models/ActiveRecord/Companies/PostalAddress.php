<?php

namespace app\models\ActiveRecord\Companies;

use yii\db\ActiveQuery;

/**
 * Description of PostalAddress
 *
 * @author kotov
 */
class PostalAddress extends Address
{
    const BASE_COMPANY = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%postal_addresses}}';
    }
    
    /**
     * Gets query for [[Company]].
     *
     * @return ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasMany(Company::class, ['postal_address_id' => 'id']);
    }
}
