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
        $statusList[Request::STATUS_NEW] = t('New','requests');
        if ($isMember) {
            $statusList[Request::STATUS_DRAFT] = t('Draft','requests');
        }
        $statusList[Request::STATUS_PAID] = t('Paid','requests');
        $statusList[Request::STATUS_PARTIAL_PAID] = t('Partial paid','requests');
        $statusList[Request::STATUS_CHANGED] = t('Changed','requests');
        $statusList[Request::STATUS_REJECTED] = t('Rejected','requests');
        return $statusList;
    }

}
