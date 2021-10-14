<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Forms\FormReadRepository;
use app\core\services\operations\Forms\FormService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\Form;
use app\models\Forms\Manage\Forms\FormsForm;
use app\models\SearchModels\Forms\FieldSearch;
use app\models\SearchModels\Forms\FormSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * Description of FormsConrtroller
 *
 * @author kotov
 */
class FormsController extends BaseAdminController
{
    use GridViewTrait;
    /**
     *
     * @var FormService
     */
    protected $service;

    public function actions()
    {
        return [
            'fields-sorting' => [
                'class' => Sorting::class,
                'query' => Field::find(),
           ],
            'forms-sorting' => [
                'class' => Sorting::class,
                'query' => Form::find(),
            ],            
        ];
    }
    
    public function __construct(
            $id, 
            $module, 
            FormReadRepository $repository,
            FormService $service,
            FormSearch $searchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

    public function actionView($id)
    {
        Url::remember();
        $fieldsList = Field::find()->availableForForm($id)->orderBy(['order'  => SORT_ASC]);
        $fieldDataProvider = new ActiveDataProvider([
            'query' => $fieldsList,
            'sort' => false
        ]);        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'fieldDataProvider' => $fieldDataProvider
        ]);
    }
    
    public function actionPublish($id)
    {
        $this->service->publish($id);
        return $this->redirect(['view', 'id' => $id]);
    }    
    
    public function actionUnpublish($id)
    {
        $this->service->unpublish($id);
        return $this->redirect(['view', 'id' => $id]);
    }     
    
     public function actionCreate()
    {
        $form = new FormsForm();
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
        Url::remember();
        $formFieldsSearchModel = new FieldSearch();        
        $formFieldsDataProvider = $formFieldsSearchModel->searchForForm($id , Yii::$app->request->queryParams); 
        $model = $this->findModel($id);
        $form = new FormsForm($model);        
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
            'formFieldsDataProvider' => $formFieldsDataProvider,
            'formFieldsModel' => $formFieldsSearchModel,            
        ]);                        
    }  
}
