<?php

namespace app\models\Forms\Manage\Contract;

use app\models\ActiveRecord\Contract\StandNumber;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of StandNumberForm
 *
 * @author kotov
 */
class StandNumberForm extends ManageForm
{
    /**
     * 
     * @var string
     */
    public $number;
    
    /**
     * {@inheritdoc}
     */      
    public function __construct(StandNumber $model = null,$config = [])
    {
        if ($model) {
            $this->number = $model->number;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number'], 'required'],
            [['number'], 'string', 'max' => 255],
        ];
    }  
    
    public function attributeLabels(): array
    {
        return [
            'number' => t('Number')
        ];
    }
}
