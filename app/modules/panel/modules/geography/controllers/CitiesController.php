<?php

namespace app\modules\panel\modules\geography\controllers;

use app\core\repositories\readModels\Geography\CityReadRepository;
use app\core\services\operations\Forms\ElementTypeService;
use app\core\services\operations\Geography\CityService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Geography\City;
use app\models\Forms\Geography\CityForm;
use app\models\SearchModels\Geography\CitySearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of CitiesController
 *
 * @author kotov
 */
class CitiesController extends BaseAdminController
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
            CityReadRepository $repository,
            CityService $service,
            CitySearch $searchModel,
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
        $form = new CityForm();
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
        /* @var $model City */
        $model = $this->findModel($id);
        $model->disableMultilang();
        $form = new CityForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }     
}
