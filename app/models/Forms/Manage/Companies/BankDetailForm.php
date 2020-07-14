<?php

namespace app\models\Forms\Manage\Companies;

use app\models\ActiveRecord\Companies\BankDetail;
use yii\base\Model;

/**
 * Description of BankDetailForm
 *
 * @author kotov
 */
class BankDetailForm extends Model
{  
    /** @var int */    
    public $id;
    /** @var string */
    public $rsSchet;
    /** @var string */    
    public $ksSchet;
    /** @var string */    
    public $bik;
    /** @var string */    
    public $bankInfo;

    public function __construct(BankDetail $model = null, $config = array())
    {
        if ($model) {
            $this->rsSchet = $model->rs_schet;
            $this->ksSchet = $model->ks_schet;
            $this->bankInfo = $model->bank_info;
            $this->bik = $model->bik;
            $this->id = $model->id;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rsSchet', 'bankInfo', 'ksSchet', 'bik'], 'safe'],
            [['rsSchet', 'bankInfo', 'ksSchet', 'bik'], 'string', 'max' => 255],
            [['id'],'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rsSchet' => 'Расчетный счет',
            'bankInfo' => 'Информация о банке',
            'ksSchet' => 'Корреспондентскй счет',
            'bik' => 'Бик',
        ];
    }    
}
