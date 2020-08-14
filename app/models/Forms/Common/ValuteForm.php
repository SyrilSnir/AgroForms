<?php

namespace app\models\Forms\Common;

use app\models\ActiveRecord\Common\Valute;
use yii\base\Model;

/**
 * Description of ValuteForm
 *
 * @author kotov
 */
class ValuteForm extends Model
{
    public $name;
    public $intName;
    public $charCode;
    public $symbol;
    
    public function __construct(Valute $model = null, $config = [])
    {
        if ($model) {
            $this->name = $model->name;
            $this->intName = $model->name_eng;
            $this->charCode = $model->char_code;
            $this->symbol = $model->symbol;
        }
        parent::__construct($config);        
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'intName', 'charCode', 'symbol'], 'string', 'max' => 255],
            [['intName', 'charCode', 'symbol'], 'default', 'value' => ''],
        ];
    } 
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'intName' => 'Международное название',
            'charCode' => 'Трехбуквенное обозначение',
            'symbol' => 'Символьный код',
        ];
    }    
    
}
