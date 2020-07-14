<?php

namespace app\models\ActiveRecord\Companies;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%bank_details}}".
 *
 * @property int $id
 * @property string $rs_schet Расчетный счет
 * @property string $bank_info Информация о банке
 * @property string $ks_schet Корреспондентскй счет
 * @property string $bik Бик
 *
 * @property Companies[] $companies
 */
class BankDetail extends ActiveRecord
{
    const BASE_COMPANY = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bank_details}}';
    }

    public static function create(
                string $rsSchet,
                string $ksSchet,
                string $bankInfo,
                string $bik
            ):self
    {
        $bankDetail = new self();
        $bankDetail->rs_schet = $rsSchet;
        $bankDetail->ks_schet = $ksSchet;
        $bankDetail->bik = $bik;
        $bankDetail->bank_info = $bankInfo;
        return $bankDetail;
    }
    
    public function edit(
                string $rsSchet,
                string $ksSchet,
                string $bankInfo,
                string $bik            
            )
    {
        $this->rs_schet = $rsSchet;
        $this->ks_schet = $ksSchet;
        $this->bik = $bik;
        $this->bank_info = $bankInfo;        
    }

    /**
     * Gets query for [[Companies]].
     *
     * @return ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Companies::className(), ['bank_details_id' => 'id']);
    }
}
