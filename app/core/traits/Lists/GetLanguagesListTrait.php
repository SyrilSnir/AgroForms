<?php

namespace app\core\traits\Lists;

use Yii;

/**
 *
 * @author kotov
 */
trait GetLanguagesListTrait
{
    public function languagesList()
    {
        return [
            0 => Yii::t('app','Russian'),
            1 => Yii::t('app','English'),      
        ];
    }     
}
