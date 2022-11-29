<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\models\ActiveRecord\Contract\Hall;
use Yii;

/**
 * Description of HallController
 *
 * @author kotov
 */
class HallController extends JsonController
{
    public function actionSave()
    {
        $hallName = trim(Yii::$app->request->post('val'));
        $hall = Hall::find()->andWhere(['name' => $hallName])->one();
        if ($hall) {
            // --------------
            return [];
        }
        $model = Hall::createByName($hallName);
        $model->save();
        return [
            'id' => $model->id,
            'text' => $model->name           
        ];
    }
}
