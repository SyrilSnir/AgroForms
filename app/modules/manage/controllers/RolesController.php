<?php

namespace app\modules\manage\controllers;

use app\core\repositories\readModels\User\UserTypeReadRepository;
use app\core\services\operations\Users\UserTypeService;
use app\models\Forms\Manage\Users\UserTypeForm;
use app\models\Forms\RowsCountForm;
use app\models\SearchModels\Users\UserTypeSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use BadMethodCallException;
use Yii;

/**
 * Description of RolesController
 *
 * @author kotov
 */
class RolesController extends BaseAdminController
{
    
    /**
     *
     * @var UserTypeService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            UserTypeReadRepository $repository,
            UserTypeService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  
    
    public function actionIndex() 
    {
        $searchModel = new UserTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);  
        $rowsCountForm = new RowsCountForm();        
        if (!($rowsCountForm->load(Yii::$app->request->get()) && $rowsCountForm->validate())) {       
            $rowsCountForm->rowsCount = RowsCountForm::DEFAULT_ROWS_COUNT;
        }   
        $dataProvider->pagination = ['pageSize' => $rowsCountForm->rowsCount];       
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'rowsCountForm' => $rowsCountForm            
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new UserTypeForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);                        
    } 
    

    public function actionDelete($id)
    {
        throw new BadMethodCallException('Запрещенная операция');
    }
}
