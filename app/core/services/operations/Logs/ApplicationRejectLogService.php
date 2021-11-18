<?php

namespace app\core\services\operations\Logs;

use app\models\ActiveRecord\Logs\ApplicationRejectLog;

/**
 * Description of ApplicationRejectLogService
 *
 * @author kotov
 */
class ApplicationRejectLogService
{
    public function clearActualStatusForRequest(int $requestId)
    {
        ApplicationRejectLog::updateAll(['actual' => false],['request_id' => $requestId]);
    }
}
