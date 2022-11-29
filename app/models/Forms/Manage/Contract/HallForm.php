<?php

namespace app\models\Forms\Manage\Contract;

use app\models\ActiveRecord\Contract\Hall;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of HallForm
 *
 * @author kotov
 */
class HallForm extends ManageForm
{
    /**
     * 
     * @var string
     */    
    public $name;
    
    /**
     * 
     * @var string
     */
    public $nameEng;
    
    /**
     * {@inheritdoc}
     */    
    public function __construct(Hall $model, $config = [])
    {
        if ($model) {
            $this->name = $model->name;
            $this->nameEng = $model->name_eng;
        }
        parent::__construct($config);
    }
    
    public function rules()
    {
        return [
            [['name', 'nameEng'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => t('Name'),
            'nameEng' => t('Name') . ' (ENG)',
        ];
    }
}
