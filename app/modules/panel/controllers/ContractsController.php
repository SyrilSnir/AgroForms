<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Contracts\ContractReadRepository;
use app\core\services\operations\Contracts\ContractService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Contract\ContractForm;
use app\models\SearchModels\Contracts\ContractSearch;
use DomainException;
use Yii;

/**
 * Description of ContractsController
 *
 * @author kotov
 */
class ContractsController extends BaseAdminController
{
    use GridViewTrait;
    
    /**
     *
     * @var ContractService
     */
    protected $service;

    public function __construct(
            $id, 
            $module, 
            ContractReadRepository $repository,
            ContractService $service,
            ContractSearch $searchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->searchModel = $searchModel;
    } 

    public function actionCreate()
    {
        $form = new ContractForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $post = $this->service->create($form);
                return $this->redirect(['view', 'id' => $post->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }  
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new ContractForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }     
}
