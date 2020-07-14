<?php

namespace app\modules\manage\modules\form\controllers;

use app\core\repositories\readModels\Forms\FieldReadRepository;
use app\core\services\operations\Forms\FieldService;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\Forms\Manage\Forms\FieldForm;
use app\models\Forms\Manage\Forms\FieldParametersForm;
use app\models\SearchModels\Forms\FieldSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of FieldsController
 *
 * @author kotov
 */
class FieldsController extends BaseAdminController
{
    /**
     *
     * @var FieldService
     */
    protected $service;
    
     public function __construct(
            $id, 
            $module, 
            FieldReadRepository $repository,
            FieldService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  

    public function actionIndex() 
    {
        $searchModel = new FieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate($formId = null)
    {
        
        $form = new FieldForm();
        $loadFormData = $form->load(Yii::$app->request->post());
        if ($loadFormData) {
            $this->setFieldParamsScenario($form);
        }
        if ($loadFormData && $form->validate()) {
            try {
                $post = $this->service->create($form);
                return $this->redirect(['view', 'id' => $post->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'formId' => $formId 
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new FieldForm($model);
        $loadFormData = $form->load(Yii::$app->request->post());
        $this->setFieldParamsScenario($form);        
        if ($loadFormData && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }

    protected function setFieldParamsScenario(FieldForm $form) 
    {
        switch ($form->elementTypeId) {
            case ElementType::ELEMENT_HEADER:
                $form->parameters->setScenario(FieldParametersForm::SCENARIO_TEXT_BLOCK);
                break;
            case ElementType::ELEMENT_INFORMATION:
            case ElementType::ELEMENT_INFORMATION_IMPORTANT:
                $form->parameters->setScenario(FieldParametersForm::SCENARIO_HTML_BLOCK);
                break;
        }
    }    
}
