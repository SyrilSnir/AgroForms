<?php


namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\helpers\Data\ExhibitionHelper;
use Yii;

/**
 * Description of ExhibitionController
 *
 * @author kotov
 */
class ExhibitionController extends JsonController
{
    public function actionGetForms()
    {
        $exhibitionId = (int) Yii::$app->request->post('depdrop_parents')[0];
        if ($exhibitionId)
        {
            $forms = ExhibitionHelper::getForms($exhibitionId,true);
            $resArray = [
                'output' => $forms,
            ];
            if (count($forms) > 0) {
                $resArray['selected'] = $forms[0]['id'];
            }
            return $resArray;
        }
        return [
                    'output' => ExhibitionHelper::getForms(null,true)
            ];
    }
}
