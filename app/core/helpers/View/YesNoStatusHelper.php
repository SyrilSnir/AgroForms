<?php

namespace app\core\helpers\View;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of YesNoStatusHelper
 *
 * @author kotov
 */
class YesNoStatusHelper extends StatusHelper
{
    public static function getStatusLabel(string $status): string
    {
        switch ($status) {
            case 0: 
                $className = 'badge badge-warning';
                break;
            default: 
                $className = 'badge badge-success';
                break;
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $className,
        ]);         
    }

    public static function statusList(): array
    {
        return [t('No'),t('Yes')];
    }
}
