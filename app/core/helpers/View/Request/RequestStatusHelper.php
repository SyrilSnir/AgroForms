<?php

namespace app\core\helpers\View\Request;

use app\core\helpers\View\StatusHelper;
use app\models\ActiveRecord\Requests\BaseRequest;
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
            case BaseRequest::STATUS_NEW:
                $className = 'badge badge-info';
                break;
            case BaseRequest::STATUS_ACCEPTED:
            case BaseRequest::STATUS_CHANGED:
                $className = 'badge badge-primary';
                break;            
            case BaseRequest::STATUS_INVOICED:
                $className = 'badge badge-purple';
                break;
            case BaseRequest::STATUS_PARTIAL_PAID:
                $className = 'badge badge-olive';
                break;
            case BaseRequest::STATUS_PAID:
                $className = 'badge badge-success';
                break;  
            case BaseRequest::STATUS_REJECTED:
                $className = 'badge badge-danger';
                break;
            default:
                $className = 'badge badge-warning';
                break;
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $className,
        ]);        
    }

    public static function statusList(bool $isMember = true, bool $hasPublicate = true): array
    {
        $statusList[BaseRequest::STATUS_NEW] = t('New','requests');
        if ($isMember) {
            $statusList[BaseRequest::STATUS_DRAFT] = t('Draft','requests');
        }
        $statusList[BaseRequest::STATUS_INVOICED] = t('Invoiced','requests');
        $statusList[BaseRequest::STATUS_PAID] = t('Paid','requests');
        $statusList[BaseRequest::STATUS_PARTIAL_PAID] = t('Partial paid','requests');
        $statusList[BaseRequest::STATUS_CHANGED] = t('Changed','requests');
        $statusList[BaseRequest::STATUS_REJECTED] = t('Rejected','requests');
        $statusList[BaseRequest::STATUS_ACCEPTED] = t('Accepted','requests');
        if ($hasPublicate) {
            $statusList[BaseRequest::STATUS_PUBLICATED] = t('Published on the site','requests');
            $statusList[BaseRequest::STATUS_NOT_PUBLICATED] = t('Removed from the site','requests');
        }
        return $statusList;
    }
    
    public static function acceptedRequestsStatusList() : array
    {
        $statusList[BaseRequest::STATUS_INVOICED] = t('Invoiced','requests');
        $statusList[BaseRequest::STATUS_PAID] = t('Paid','requests');
        $statusList[BaseRequest::STATUS_PARTIAL_PAID] = t('Partial paid','requests');
        $statusList[BaseRequest::STATUS_ACCEPTED] = t('Accepted','requests');
        $statusList[BaseRequest::STATUS_PUBLICATED] = t('Published on the site','requests');
        $statusList[BaseRequest::STATUS_NOT_PUBLICATED] = t('Removed from the site','requests');        
        return $statusList;       
    }

    public static function newRequestsStatusList() : array
    {
        $statusList[BaseRequest::STATUS_NEW] = t('New','requests');
        $statusList[BaseRequest::STATUS_CHANGED] = t('Changed','requests');
        return $statusList;        
    }    
}
