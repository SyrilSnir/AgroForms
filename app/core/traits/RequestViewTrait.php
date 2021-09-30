<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits;

use app\core\services\operations\Requests\RequestService;
use app\core\services\operations\View\Requests\RequestViewFactory;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ChangeStatusForm;
use Yii;

/**
 *
 * @author kotov
 */
trait RequestViewTrait
{    
    /**
     *
     * @var RequestService
     */
    protected $service;
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {        
        /** @var Request $model */
        $this->viewPath = Yii::getAlias('@views') .  DIRECTORY_SEPARATOR .'requests';        
        $model = $this->findModel($id);
        $requestForm = $model->requestForm;
        $viewService = RequestViewFactory::getViewService($model);
        $dopAttributes = $viewService->getFieldAttributes($requestForm);
        $statusForm = new ChangeStatusForm($model->id, $model->status);        
        if ($statusForm->load(Yii::$app->request->post()) && $statusForm->validate()) {
            $model = $this->service->changeStatus($statusForm);
            Yii::$app->session->setFlash('success','Статус заявки успешно изменен');            
        }
        return $this->render('view', [
            'model' => $model,
            'dopAttributes' => $dopAttributes,
            'statusForm' => $statusForm,
        ]);
    }
}
