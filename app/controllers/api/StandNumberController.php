<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\models\ActiveRecord\Contract\StandNumber;
use Yii;

/**
 * Description of StandNumberController
 *
 * @author kotov
 */
class StandNumberController extends JsonController
{
    public function actionSave()
    {
        $standNumberName = trim(Yii::$app->request->post('val'));
        $standNumber = StandNumber::find()->andWhere(['number' => $standNumberName])->one();
        if ($standNumber) {
            // --------------
            return [];
        }
        $model = StandNumber::createByNumber($standNumberName);
        $model->save();
        return [
            'id' => $model->id,
            'text' => $model->number           
        ];
    }
}
