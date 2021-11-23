<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;
use yii\base\Model;

/**
 * Description of FieldEnumForm
 *
 * @author kotov
 */
class FieldEnumForm extends Model
{
    public $name;
    public $nameEng;
    public $fieldId;
    public $value;
    
    public function __construct(FieldEnum $model = null, $config = [])
    {
        if ($model) {
            $this->name = $model->name;
            $this->nameEng = $model->name_eng;
            $this->value = $model->value;
            $this->fieldId = $model->field_id;
        }
        parent::__construct($config);
    }
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fieldId', 'name', 'value'], 'required'],          
            [['fieldId'], 'integer'],
            [['name', 'value','nameEng'], 'string', 'max' => 255],
            [['fieldId'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['fieldId' => 'id']],
        ];
    } 
    
    public function attributeLabels(): array
    {
        return [
            'name' => t('Item name'),
            'nameEng' => t('Item name') . ' (ENG)',
            'value' => t('Value'),
        ];
    }
}
