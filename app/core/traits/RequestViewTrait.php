<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits;

use app\core\services\operations\View\Requests\RequestViewFactory;
use app\models\ActiveRecord\Requests\Request;

/**
 *
 * @author kotov
 */
trait RequestViewTrait
{    
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {        
        /** @var Request $model */
        $this->viewPath = \Yii::getAlias('@views') .  DIRECTORY_SEPARATOR .'requests';        
        $model = $this->findModel($id);
        $requestForm = $model->requestForm;
        $viewService = RequestViewFactory::getViewService($model);
        $dopAttributes = $viewService->getFieldAttributes($requestForm);

        return $this->render('view', [
            'model' => $model,
            'dopAttributes' => $dopAttributes
        ]);
    }
}
