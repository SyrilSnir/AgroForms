<?php

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\FormType;
use yii\base\Model;

/**
 * Description of FormTypeForm
 *
 * @author kotov
 */
class FormTypeForm extends Model
{
    public $name;
    
    public $description;
    
    public $nameEng;
    
    public $descriptionEng;
    
    public function __construct(FormType $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->description = $model->description;
            $this->nameEng = $model->name_eng;
            $this->descriptionEng = $model->description_eng;
            
        }
        parent::__construct($config);
    }
    
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['description','nameEng','descriptionEng'], 'safe'],
        ];
    }
    
    public function attributeLabels(): array {
        return [
            'name' => t('Form type', 'requests'),
            'description' => t('Description'),
            'nameEng' => 'Тип формы (ENG)',
            'descriptionEng' => 'Описание (ENG)',            
        ];
    }    
}
