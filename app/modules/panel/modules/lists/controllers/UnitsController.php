<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Nomenclature\UnitReadRepository;
use app\core\services\operations\Nomenclature\UnitService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Nomenclature\UnitForm;
use app\models\SearchModels\Nomenclature\UnitSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of UnitsController
 *
 * @author kotov
 */
class UnitsController extends BaseAdminController
{

    use GridViewTrait;
    
    /**
     *
     * @var UnitService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            UnitReadRepository $repository,
            UnitService $service,
            UnitSearch $searchModel,
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
        $form = new UnitForm();
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
        $form = new UnitForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
