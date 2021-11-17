<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\core\repositories\readModels\Logs;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Logs\ApplicationRejectLog;

/**
 * Description of ApplicationRejectLogReadRepository
 *
 * @author kotov
 */
class ApplicationRejectLogReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return ApplicationRejectLog::find()
            ->andWhere(['id' => $id])
            ->one();
    }
    
    public function findActualForRequest(int $requestId) : ?ApplicationRejectLog
    {
        return ApplicationRejectLog::find()
                ->andWhere(['request_id' => $requestId])
                ->andWhere(['actual' => true])
                ->one();
    }
}
