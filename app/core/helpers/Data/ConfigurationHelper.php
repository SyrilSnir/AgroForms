<?php

namespace app\core\helpers\Data;

use app\models\ActiveRecord\Configuration;


/**
 * Description of ConfigurationHelper
 *
 * @author kotov
 */
class ConfigurationHelper
{
    /**
     * @todo Сделать после добавления насчтроек
     * @param string $section
     * @return array
     */
    public static function getConfig(string $section):array
    {
        return \yii\helpers\ArrayHelper::map(Configuration::find()
                ->select(['name','value'])
                ->where(['section' => $section])
                ->asArray()
                ->all(),'name','value');
    }
}
