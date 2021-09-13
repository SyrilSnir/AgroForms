<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\ReadRepositoryInterface;
use DomainException;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Description of ManageController
 *
 * @author kotov
 */
class ManageController extends AccessRule\BaseController
{
    /**
     *
     * @var ReadRepositoryInterface
     */
    protected $readRepository;
    
     /**
     * @param integer $id
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->readRepository->findById($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }      

}
