<?php

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\FieldLabels;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of FieldLabelForm
 *
 * @author kotov
 */
class FieldLabelForm extends ManageForm
{
    public $name;
    
    public $nameEng;
    
    public $code;
    
    public function __construct(FieldLabels $model, $config = [])
    {
        if ($model) {
            $this->name = $model->name;
            $this->nameEng = $model->name_eng;
            $this->code = $model->code;
        }
        parent::__construct($config);
    }   
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name', 'nameEng', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => t('Name'),
            'nameEng' => t('Name'). '(ENG)',
            'code' => t('Character code'),
        ];
    }    
}
