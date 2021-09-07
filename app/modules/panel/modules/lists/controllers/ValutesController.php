<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Common\ValuteReadRepository;
use app\core\services\operations\Common\ValuteService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Common\ValuteForm;
use app\models\SearchModels\Common\ValuteSearch;
use app\modules\panel\controllers\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of ValutesController
 *
 * @author kotov
 */
class ValutesController extends BaseAdminController
{
    use GridViewTrait;
    /**
     *
     * @var ValuteService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            ValuteReadRepository $repository,
            ValuteService $service,
            ValuteSearch $searchModel,
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
        $form = new ValuteForm();
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
        $form = new ValuteForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
