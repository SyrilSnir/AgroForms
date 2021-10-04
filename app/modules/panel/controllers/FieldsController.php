<?php

namespace app\modules\panel\controllers;

use app\core\providers\Data\FieldEnumProvider;
use app\core\repositories\readModels\Forms\FieldReadRepository;
use app\core\services\operations\Forms\FieldService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;
use app\models\Forms\Manage\Forms\FieldForm;
use app\models\Forms\Manage\Forms\FieldParametersForm;
use app\models\SearchModels\Forms\FieldSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

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
     * @var FieldEnumProvider
     */
    protected $fieldEnumProvider;
    
     public function __construct(
            $id, 
            $module, 
            FieldReadRepository $repository,
            FieldService $service,
            FieldEnumProvider $fieldEnumProvider,
            FieldSearch $searchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->fieldEnumProvider = $fieldEnumProvider;
        $this->searchModel = $searchModel;
    }
    
    public function actionCreate($formId = null)
    {
        
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
            'enumsList' => $enumsList            
        ]);
    }

    public function actionUpdate($id)
    {
        /** @var Field $model */
        $model = $this->findModel($id);
        $form = new FieldForm($model);
        $loadFormData = $form->load(Yii::$app->request->post());
        $this->setFieldParamsScenario($form); 
        $enumsPresent = $model->hasEnums();
        if (!$enumsPresent) {
            Yii::$app->session->remove(FieldEnum::SESSION_IDENTIFIER); 
            $enumsList = [];            
        } else {
            if (!$loadFormData) {
                $enumsList = $this->fieldEnumProvider->getEnumsList($model);
                Yii::$app->session->set(FieldEnum::SESSION_IDENTIFIER, $enumsList);                
            } else {
                $enumsList = Yii::$app->session->get(FieldEnum::SESSION_IDENTIFIER, []);                
            }
        }
        if ($loadFormData && $form->validate()) {
            $this->service->edit($id, $form);
            if ($enumsPresent) {
                $this->service->addEnums($model, $enumsList);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
            'enumsList' => $enumsList
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
