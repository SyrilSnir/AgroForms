<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\Response;
use Yii;
/**
 * Description of JsonController
 *
 * @author kotov
 */
abstract class JsonController extends Controller
{    
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;        
    }
}
