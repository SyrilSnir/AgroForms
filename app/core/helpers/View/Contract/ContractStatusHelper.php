<?php

namespace app\core\helpers\View\Contract;

use app\core\helpers\View\StatusHelper;
use app\models\ActiveRecord\Contract\Contracts;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of ContractStatusHelper
 *
 * @author kotov
 */
class ContractStatusHelper extends StatusHelper
{
    public static function statusList() :array
    {
        $statusList = [
            Contracts::STATUS_ACTIVE => t('Active','contracts'),
            Contracts::STATUS_COMPLETED => t('Completed','contracts'),
            Contracts::STATUS_DECLINED => t('Declined','contracts'),
        ];
        return $statusList;
    }

    public static function getStatusLabel(string $status): string
    {
        switch ($status) {
            case Contracts::STATUS_ACTIVE:
                $className = 'badge badge-info';
                break;
            case Contracts::STATUS_COMPLETED:
                $className = 'badge badge-success';
                break;            
            default:
                $className = 'badge badge-warning';
                break;
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $className,
        ]); 
    }
}
