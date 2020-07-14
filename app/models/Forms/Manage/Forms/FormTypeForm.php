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
    
    public function __construct(FormType $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->description = $model->description;
        }
        parent::__construct($config);
    }
    
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['description'], 'safe'],
        ];
    }
    
    public function attributeLabels(): array {
        return [
            'name' => 'Тип формы',
            'description' => 'Описание',
        ];
    }    
}
