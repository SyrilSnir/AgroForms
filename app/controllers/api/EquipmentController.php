<?php

namespace app\controllers\api;

use app\controllers\JsonController;
/**
 * Description of EquipmentController
 *
 * @author kotov
 */
class EquipmentController extends JsonController
{
    public function actionGetCategories():array
    {
        return [
            1 => 'Превед',
            2 => 'Медвед'
        ];
    }
}
