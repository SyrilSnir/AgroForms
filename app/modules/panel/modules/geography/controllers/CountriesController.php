<?php

namespace app\modules\panel\modules\geography\controllers;

use app\core\repositories\readModels\Geography\CountryReadRepository;
use app\core\services\operations\Geography\CountryService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Geography\Country;
use app\models\Forms\Geography\CountryForm;
use app\models\SearchModels\Geography\CountrySearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of CountriesController
 *
 * @author kotov
 */
class CountriesController extends BaseAdminController
{
    use GridViewTrait;
    /**
     *
     * @var CountryService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            CountryReadRepository $repository,
            CountryService $service,
            CountrySearch $searchModel,
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
        $form = new CountryForm();
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
        /* @var $model Country */
        $model = $this->findModel($id);
        $model->disableMultilang();
        $form = new CountryForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }      
}
