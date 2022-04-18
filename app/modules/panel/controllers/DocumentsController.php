<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Documents\DocumentReadRepository;
use app\core\services\operations\Documents\DocumentService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Document\DocumentForm;
use app\models\SearchModels\Documents\ManagerDocumentSearch;
use DomainException;
use Yii;

/**
 * Description of DocumentsController
 *
 * @author kotov
 */
class DocumentsController extends BaseAdminController
{
    use GridViewTrait;
    /**
     *
     * @var DocumentService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            DocumentReadRepository $repository,
            DocumentService $service,
            ManagerDocumentSearch $searchModel,
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
        $form = new DocumentForm();
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
        $form = new DocumentForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
    
}
