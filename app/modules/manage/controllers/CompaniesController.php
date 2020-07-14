<?php

namespace app\modules\manage\controllers;

use app\core\repositories\readModels\Companies\CompanyReadRepository;
use app\core\services\operations\Companies\CompanyService;
use app\models\ActiveRecord\Companies\Company;
use app\models\Forms\Manage\Companies\CompanyForm;
use app\models\Forms\Manage\Users\MemberForm;
use app\models\SearchModels\Companies\CompanySearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use DomainException;
use Yii;

/**
 * Description of CompaniesController
 *
 * @author kotov
 */
class CompaniesController extends BaseAdminController
{
    
    /**
     *
     * @var CompanyService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            CompanyReadRepository $repository,
            CompanyService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  
    
    public function actionIndex() 
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $form = new CompanyForm();
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

    public function actionAddMember($id)
    {
        /** @var Company $model */
        $model = $this->findModel($id);
        $form = new MemberForm();
        $form->company = $model->id;
        $form->fio = $model->contacts->manager_fio;
        $form->login = $model->contacts->manager_email;
        $form->email = $model->contacts->manager_email;
        $form->phone = $model->contacts->manager_phone;
        $form->member->proposalSignatureName = $model->contacts->chief_fio;
        $form->member->proposalSignaturePost = $model->contacts->chief_email;
        return $this->render('../users/create-member', [
            'model' => $form,
        ]);   
        
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new CompanyForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    }    
}
