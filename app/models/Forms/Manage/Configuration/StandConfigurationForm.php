<?php

namespace app\models\Forms\Manage\Configuration;

use Yii;
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
            'frizeFreeDigits' => Yii::t('app','The number of free characters in the frieze inscription'),
            'frizeDigitPrice' => Yii::t('app','The cost of the frieze lettering symbol'),
        ];
    }
}
