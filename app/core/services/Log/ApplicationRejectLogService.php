<?php

namespace app\core\services\Log;

use app\core\repositories\readModels\Logs\ApplicationRejectLogReadRepository;
use yii\web\Request;

/**
 * Description of ApplicationRejectLogService
 *
 * @author kotov
 */
class ApplicationRejectLogService
{
    /**
     * 
     * @var ApplicationRejectLogReadRepository
     */
    private $applicationRejectLogRepository;
    
    public function __construct(ApplicationRejectLogReadRepository $applicationRejectLogRepository)
    {
        $this->applicationRejectLogRepository = $applicationRejectLogRepository;
    }

    public function getLogsForRequest(int $requestId)
    {
        /** @var Request $request */
        $aResult = [
          'active' => [],
          'history' => []
        ];
        $activeMessage = $this->applicationRejectLogRepository->findActualForRequest($requestId);
        $historyMessages = $this->applicationRejectLogRepository->findArchiveLogsForRequest($requestId);
        if ($activeMessage) {
            $aResult['active'] = $activeMessage;
        }
        if (!empty($historyMessages)) {
            $aResult['history'] = $historyMessages;
        }
        return $aResult;
    }
}
