<?php

namespace app\modules\manage\controllers;

use app\core\repositories\readModels\User\UserTypeReadRepository;
use app\core\services\operations\Users\UserTypeService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Manage\Users\UserTypeForm;
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
    use GridViewTrait;    
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
            UserTypeSearch $searchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }  
    
    public function actionUpdate($id)
    {
        /* @var $model UserType */
        $model = $this->findModel($id);        
        $model->disableMultilang();
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
        throw new BadMethodCallException(Yii::t('app','Forbidden operation'));
    }
}
