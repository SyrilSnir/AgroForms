<?php

namespace app\modules\panel\controllers;

use app\core\helpers\Data\ConfigurationHelper;
use app\core\repositories\readModels\Forms\StandReadRepository;
use app\core\services\operations\Forms\StandService;
use app\core\services\operations\SettingsService;
use app\models\ActiveRecord\Configuration;
use app\models\Forms\Manage\Configuration\StandConfigurationForm;
use app\models\Forms\Manage\Forms\StandForm;
use app\models\SearchModels\Forms\StandSearch;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of StandsController
 *
 * @author kotov
 */
class StandsController extends BaseAdminController
{
    /**
     *
     * @var StandService
     */
    protected $service;
    /**
     *
     * @var SettingsService
     */
    protected $settingsService;
    
     public function __construct(
            $id, 
            $module, 
            StandReadRepository $repository,
            StandService $service,
            SettingsService $settingsService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->settingsService = $settingsService;
    }  

    public function actionIndex() 
    {
        $searchModel = new StandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        $form = new StandForm();
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
        $form = new StandForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }
    
    public function actionSettings()
    {
        $form = new StandConfigurationForm();
        $config = ConfigurationHelper::getConfig(Configuration::STAND_SETTINGS_SECTION);
        if ($config) {
            $form->setAttributes($config);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->settingsService->saveConfiguration($form, Configuration::STAND_SETTINGS_SECTION);
            Yii::$app->session->setFlash('configurationSaved', 'Конфигурация успешно сохранена');
        }
        return $this->render('settings',[
            'model' => $form
        ]);
    }
}
