<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits;

use app\models\Data\Status;
use Yii;

/**
 *
 * @author kotov
 */
trait InfoMessageTrait
{
    /**
     * 
     * @param string $message
     * @return string
     */
    private function getMessage(string $message)
    {
        return $this->getInfo($message);
    }

    /**
     * 
     * @param string $message
     * @return string
     */
    private function getErrorMessage(string $message)
    {
        return $this->getInfo($message, Status::STATUS_ERROR);
    }

    /**
     * 
     * @param string $message
     * @param int $status
     * @return string
     */
    private function getInfo(string $message,int $status = Status::STATUS_OK)
    {
        switch ($status) {
            case Status::STATUS_OK:
                Yii::$app->session->setFlash('success',$message);
                break;
            case Status::STATUS_ERROR:
                Yii::$app->response->setStatusCode(400);
                Yii::$app->session->setFlash('error',$message);
                break;                
        }
        return;
    }
}
