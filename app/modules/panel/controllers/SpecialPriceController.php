<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Forms\SpecialPriceReadRepository;
use app\core\services\operations\Forms\SpecialPriceService;
use app\models\Forms\Manage\Forms\SpecialPriceForm;
use DomainException;
use Yii;

/**
 * Description of SpecialPriceController
 *
 * @author kotov
 */
class SpecialPriceController extends BaseAdminController
{
    /**
     *
     * @var SpecialPriceService
     */
    protected $service;
    
    /**
     *
     * @var SpecialPriceReadRepository
     */
    protected $readRepository;    
    
     public function __construct(
            $id, 
            $module, 
            SpecialPriceService $service,
            SpecialPriceReadRepository $repository,
            $config = array()
            )
     {
         parent::__construct($id, $module, $config);
         $this->service = $service;
         $this->readRepository = $repository;
     }
    public function actionCreate($fieldId)
    {
        $form = new SpecialPriceForm();
        
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $post = $this->service->create($form);
                return $this->redirect(['view', 'id' => $post->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        } else {
            $form->fieldId = $fieldId;
        }
        
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new SpecialPriceForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    } 
    
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
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
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->refresh();
    }

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
}
