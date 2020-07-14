<?php

namespace app\models\Forms\Manage\Configuration;

use yii\base\Model;

/**
 * Description of StandConfiguration
 *
 * @author kotov
 */
class StandConfigurationForm extends Model implements ConfigurationFormInterface
{
    public $frizeFreeDigits;
    
    public $frizeDigitPrice;
 
    public function rules(): array
    {
        return [
            [['frizeFreeDigits','frizeDigitPrice'],'integer']
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'frizeFreeDigits' => 'Количество бесплатных знаков во фризовой надписи',
            'frizeDigitPrice' => 'Стоимость символа фризовой надписи',
        ];
    }
}
