<?php


namespace app\models\Forms\Manage\Contract;

use app\core\traits\Lists\GetMediaFeeTypesTrait;
use app\models\ActiveRecord\Contract\ContractMediaFees;
use app\models\ActiveRecord\Contract\Contracts;
use app\models\ActiveRecord\Contract\MediaFeeTypes;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of ContractMediaFeeForm
 *
 * @author kotov
 */
class ContractMediaFeeForm extends ManageForm
{
    use GetMediaFeeTypesTrait;
    /**
     * 
     * @var int
     */
    public $contractId;
    
    /**
     * 
     * @var int
     */
    public $mediaFeeType;
    
    /**
     * 
     * @var int
     */
    public $count;
    
    public function __construct(ContractMediaFees $model = null, $config = []) 
    {
        if ($model) {
            $this->contractId = $model->contract_id;
            $this->mediaFeeType = $model->media_fee_type;
            $this->count = $model->count;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contractId', 'count'], 'required'],
            [['contractId', 'mediaFeeType', 'count'], 'integer'],
            [['contractId'], 'exist', 'skipOnError' => true, 'targetClass' => Contracts::class, 'targetAttribute' => ['contractId' => 'id']],
            [['mediaFeeType'], 'exist', 'skipOnError' => true, 'targetClass' => MediaFeeTypes::class, 'targetAttribute' => ['mediaFeeType' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contractId' => 'Contract ID',
            'mediaFeeType' => t('Type of media contributions'),
            'count' => t('Count'),
        ];
    }    
}
