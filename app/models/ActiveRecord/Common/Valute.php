<?php

namespace app\models\ActiveRecord\Common;

use Yii;

/**
 * This is the model class for table "{{%valutes}}".
 *
 * @property int $id
 * @property string $name Наименование
 * @property string|null $int_name Международное название
 * @property string|null $char_code Трехбуквенное обозначение
 * @property string|null $symbol Символьный код
 */
class Valute extends \yii\db\ActiveRecord
{
    const RUB = 1;
    const USD = 2;
    const EUR = 3;
    
    public static function create(
            string $name,
            string $intName = '',
            string $charCode = '',
            string $symbol = ''
            ):self 
    {
        $valute = new self();
        $valute->name = $name;
        $valute->int_name = $intName;
        $valute->char_code = $charCode;
        $valute->symbol = $symbol;
        return $valute;
    }
    
    public function edit(
            string $name,
            string $intName = '',
            string $charCode = '',
            string $symbol = ''            
            )
    {
        $this->name = $name;
        $this->int_name = $intName;
        $this->char_code = $charCode;
        $this->symbol = $symbol;        
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%valutes}}';
    }
}
