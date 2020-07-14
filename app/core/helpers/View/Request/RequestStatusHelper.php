<?php

namespace app\core\helpers\View\Request;

use app\core\helpers\View\StatusHelper;
use app\models\ActiveRecord\Requests\Request;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of RequestStatusHelper
 *
 * @author kotov
 */
class RequestStatusHelper extends StatusHelper
{
    /**
     * 
     * @param string $status
     * @return type
     */
    public static function getStatusLabel(string $status):string
    {
        switch ($status) {
            case Request::STATUS_NEW:
                $className = 'badge badge-info';
                break;
            default:
                $className = 'badge badge-warning';
                break;
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $className,
        ]);        
    }

    public static function statusList(bool $isMember = true): array
    {
        $statusList[Request::STATUS_NEW] = 'Новая';
        if ($isMember) {
            $statusList[Request::STATUS_DRAFT] = 'Черновик';
        }
        $statusList[Request::STATUS_PAID] = 'Оплачена';
        $statusList[Request::STATUS_REJECTED] = 'Отменена';
        return $statusList;
    }

}
