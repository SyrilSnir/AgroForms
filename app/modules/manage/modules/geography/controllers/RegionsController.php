<?php

namespace app\modules\manage\modules\geography\controllers;

use app\core\repositories\readModels\Geography\RegionReadRepository;
use app\core\services\operations\Forms\ElementTypeService;
use app\core\services\operations\Geography\RegionService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Geography\RegionForm;
use app\models\SearchModels\Geography\RegionSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of RegionsController
 *
 * @author kotov
 */
class RegionsController extends BaseAdminController
{
    use GridViewTrait;
    /**
     *
     * @var ElementTypeService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            RegionReadRepository $repository,
            RegionService $service,
            RegionSearch $searchModel,
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
        $form = new RegionForm();
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
        $form = new RegionForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }     
}
