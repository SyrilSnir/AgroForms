<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Contracts\ContractMediaFeeReadRepository;
use app\core\services\operations\Contracts\ContractMediaFeeService;
use app\models\Forms\Manage\Contract\ContractMediaFeeForm;
use DomainException;
use Yii;
use yii\helpers\Url;

/**
 * Description of MediaFeeController
 *
 * @author kotov
 */
class MediaFeeController extends BaseAdminController
{
    /**
     * 
     * @var ContractMediaFeeService
     */
    protected $service; 
    
    /**
     *
     * @var ContractMediaFeeReadRepository
     */
    protected $readRepository;      

    public function __construct(
            $id, 
            $module,
            ContractMediaFeeService $service,
            ContractMediaFeeReadRepository $repository,
            $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->readRepository = $repository;
    }
    
    public function actionCreate($contractId)
    {
        $form = new ContractMediaFeeForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {                
                $this->service->create($form);
                return $this->redirect(Url::previous());
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }        
        $form->contractId = $contractId;
        return $this->render('create', [
            'model' => $form,               
        ]);            
    }
    
    public function actionUpdate($id)
    {
        $model = $this->readRepository->findById($id);
        $form = new ContractMediaFeeForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {                
                $this->service->edit($id, $form);
                return $this->redirect(Url::previous());
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }        
        return $this->render('update', [
            'model' => $form,               
        ]);         
    }
    
    public function actionDelete($id) 
    {
        $this->service->remove($id);
        return $this->redirect(Url::previous());
    }    
}
