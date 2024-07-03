<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\User\ManagerRoleReadRepository;
use app\core\services\operations\Users\ManagerRoleService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Users\ManagerRoleForm;
use app\models\Forms\Manage\Users\ManagerRoleRulesForm;
use app\models\SearchModels\Users\ManagerRoleRulesSearch;
use app\models\SearchModels\Users\ManagerRoleSearch;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * Description of ManagerRolesController
 *
 * @author kotov
 */
class ManagerRolesController extends CrudController
{
    use GridViewTrait;
    
    /**
     *
     * @var ManagerRoleService
     */
    protected $service;
    
    /**
     * 
     * @var ManagerRoleRulesSearch
     */
    protected $rulesSearchModel;


    public function __construct(
            $id, 
            $module, 
            ManagerRoleReadRepository $repository,
            ManagerRoleService $service,
            ManagerRoleSearch $searchModel,
            ManagerRoleRulesSearch $rulesSearch,
            ManagerRoleForm $form,
            $config = array()
            )
    {
        parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
        $this->rulesSearchModel = $rulesSearch;
    } 
    


    protected function prepareUpdate(Model $form, $id = null)
    {
        parent::prepareUpdate($form, $id);
        Url::remember();
        $this->addRulesForRole($id);
    }
    
    protected function prepareView(Model $form)
    {
        /** @var ManagerRoleForm $form */
        parent::prepareView($form);
        Url::remember();
        $this->addRulesForRole($form->id);
    }
    
    protected function addRulesForRole(int $roleId) 
    {
        $rulesForm = new ManagerRoleRulesForm();
        $this->rulesSearchModel->role_id = $roleId;
        $rulesForm->roleId = $roleId;
        $rulesProvider = $this->rulesSearchModel->search(Yii::$app->request->queryParams);
        $rulesProvider->pagination = false;
        $this->tplVars['rulesProvider'] = $rulesProvider;
        $this->tplVars['searchModel'] = $this->rulesSearchModel;
        $this->tplVars['roleId'] = $roleId;
    }    
}
