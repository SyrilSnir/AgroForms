<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\core\services\operations\DataManqageInterface;
use app\models\Forms\Manage\ManageForm;
use DomainException;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Description of CrudController
 *
 * @author kotov
 */
class CrudController extends BaseAdminController
{
    /**
     * 
     * @var DataManqageInterface
     */
    protected $service;    
    /**
     *
     * @var ReadRepositoryInterface
     */
    protected $readRepository;
    
    /**
     * 
     * @var ManageForm
     */
    protected $form; 
    
    /**
     * 
     * @var array Дополнительные переменные для подстановки в шаблон
     */
    protected $tplVars = [];


    public function __construct(
            $id, 
            $module, 
            DataManqageInterface $service,
            ReadRepositoryInterface $repository,
            ManageForm $form,
            $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->readRepository = $repository;
        $this->form = $form;
    }
    
    /**
     * @param integer $id
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): ActiveRecord
    {
        if (($model = $this->readRepository->findById($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->prepareView($model);
        return $this->render('view', [
            'model' => $model,
            'tplVars' => $this->tplVars
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionCreate()
    {
        $this->prepareCreate();
        if ($this->form->load(Yii::$app->request->post()) && $this->form->validate()) {
            try {
                $post = $this->service->create($this->form);
                return $this->redirect(['view', 'id' => $post->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $this->form,
            'isUpdate' => false,
            'tplVars' => $this->tplVars
        ]);
    }  
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = $this->form::createWithModel($model, $id);
        $this->prepareUpdate($form, $id);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
            'isUpdate' => true,
            'tplVars' => $this->tplVars
        ]);                        
    }
    
    protected function prepareCreate() 
    {
        $this->form->setScenario(ManageForm::SCENARIO_CREATE);
    }
    protected function prepareUpdate(Model $form, $id = null) 
    {
        $form->setScenario(ManageForm::SCENARIO_UPDATE);
    }
    protected function prepareView(Model $form) {}  
    
    protected function prepareIndex() {}
}
