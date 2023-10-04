<?php

namespace app\controllers\api;

use app\controllers\JsonController;

/**
 * Description of ExhibitorsController
 *
 * @author kotov
 */
class ExhibitorsController extends JsonController
{       
    public function actions(): array
    {
        $this->response->headers->add('Access-Control-Allow-Origin', 'http://agrosalon.local');
        return parent::actions();
    }
    public function actionIndex()
    {
        return [
            'name' => 'Вася'
        ];
    }
}
