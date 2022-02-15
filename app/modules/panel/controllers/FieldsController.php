<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Forms\FieldReadRepository;
use app\core\services\operations\Forms\FieldEnumService;
use app\core\services\operations\Forms\FieldService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;
use app\models\Forms\Manage\Forms\FieldEnumForm;
use app\models\Forms\Manage\Forms\FieldForm;
use app\models\Forms\Manage\Forms\FieldParametersForm;
use app\models\SearchModels\Forms\FieldSearch;
use app\models\SearchModels\Forms\SpecialPriceSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use yii\helpers\Url;

/**
 * Description of FieldsController
 *
 * @author kotov
 */
class FieldsController extends BaseAdminController
{
    use GridViewTrait;
    /**
     *
     * @var FieldService
     */
    protected $service;
    
    /**
     *
     * @var FieldEnumService
     */
    protected $fieldEnumService;
    
    /**
     * 
     * @var SpecialPriceSearch
     */
    protected $specialPriceSearch;

    public function actions()
    {
        return [
            'enums-sorting' => [
                'class' => Sorting::className(),
                'query' => FieldEnum::find(),
            ],
        ];
    }
    
    public function __construct(
            $id, 
            $module, 
            FieldReadRepository $repository,
            FieldService $service,
            FieldEnumService $fieldEnumService,
            FieldSearch $searchModel,
            SpecialPriceSearch $specialPriceSearch,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->fieldEnumService = $fieldEnumService;
        $this->searchModel = $searchModel;
        $this->specialPriceSearch = $specialPriceSearch;
    }
    
    public function actionCreate($formId = null)
    {        
        $previousPage = '/panel/forms/update?id=' .$formId;
        Url::remember();
        $form = new FieldForm();
        $loadFormData = $form->load(Yii::$app->request->post());
        if ($loadFormData) {
            $this->setFieldParamsScenario($form);
        } else {
            Yii::$app->session->remove(FieldEnum::SESSION_IDENTIFIER);
            $form->elementTypeId = ElementType::DEFAULT_ELEMENT_TYPE;
        }
        $enumsList = Yii::$app->session->get(FieldEnum::SESSION_IDENTIFIER, []);        
        if ($loadFormData && $form->validate()) {
            try {
                $field = $this->service->create($form);
                if ($field->hasEnums()) {
                    $this->service->addEnums($field, $enumsList);
                }
                return $this->redirect(['view', 'id' => $field->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'formId' => $formId,
            'enumsList' => $enumsList,
            'previousPage' => $previousPage,            
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionUpdate($id)
    {
        /** @var Field $model */
        Url::remember();          
        $model = $this->findModel($id);
        $model->disableMultilang();
        $previousPage = '/panel/forms/update?id=' .$model->form_id;  
        $form = new FieldForm($model);
        $loadFormData = $form->load(Yii::$app->request->post());
        $this->setFieldParamsScenario($form); 
        $enumsPresent = $model->hasEnums();
        if (!$loadFormData) {
            $enumsList = $model->enums;
            $enumsForm = new FieldEnumForm();
            $enumsForm->fieldId = $id;
            if ($enumsForm->load(Yii::$app->request->post()) && $enumsForm->validate() ) {
                $this->fieldEnumService->create($enumsForm);
                $this->response->refresh();
            }                            
        }        
        if ($loadFormData && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $dataProvider = $this->specialPriceSearch->search($id);        
        return $this->render('update', [
            'model' => $form,
            'enumsList' => $enumsList,
            'enumsPresent' => $enumsPresent,
            'previousPage' => $previousPage,
            'dataProvider' => $dataProvider,
            'enumsForm' => $enumsForm
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

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionRestore($id)
    {
        try {
            $this->service->restore($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::previous());
    }     
}
