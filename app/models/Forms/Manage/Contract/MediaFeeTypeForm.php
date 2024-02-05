<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\models\Forms\Manage\Contract;

use app\models\ActiveRecord\Contract\MediaFeeTypes;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of MediaFeeTypeForm
 *
 * @author kotov
 */
class MediaFeeTypeForm extends ManageForm
{
    public $name;
    
    public $nameEng;
    
    public function __construct(MediaFeeTypes $model = null, $config = []) 
    {
        parent::__construct($config);
        if ($model) {
            $this->name = $model->name;
            $this->nameEng = $model->name_eng;
        }
    }

    public function rules()
    {
        return [
            [['name', 'nameEng'], 'required'],
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
