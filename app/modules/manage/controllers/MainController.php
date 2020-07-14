<?php

namespace app\modules\manage\controllers;

use app\modules\manage\controllers\AccessRule\BaseController;

/**
 * Description of MainController
 *
 * @author kotov
 */
class MainController extends BaseController
{    
    public function actionIndex()
    {
        return $this->render('index');
    }
}
