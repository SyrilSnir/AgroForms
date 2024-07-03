<?php

namespace app\modules\panel\controllers\Actions;

use app\core\repositories\readModels\Forms\FormReadRepository;
use app\core\repositories\readModels\User\ManagerRoleReadRepository;
use app\core\services\operations\Users\ManagerRoleRulesService;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Users\ManagerRoles;
use app\models\Forms\Manage\Users\ManagerRoleRulesForm;
use DomainException;
use Yii;
use yii\base\Action;
use yii\helpers\Url;

/**
 * Description of CreateRuleAction
 *
 * @author kotov
 */
class CreateRuleAction  extends Action
{
    /**
     * 
     * @var ManagerRoleRulesForm
     */
    protected $form;

    /**
     * 
     * @var ManagerRoleRulesService
     */    
    protected $service;
    /**
     * 
     * @var FormReadRepository
     */    
    protected $formsRepository;
    /**
     * 
     * @var ManagerRoleReadRepository
     */    
    protected $rolesRepository;
    


    public function __construct(
            $id, 
            $controller, 
            ManagerRoleRulesForm $form,
            ManagerRoleRulesService $service,
            FormReadRepository $formsRepository,
            ManagerRoleReadRepository $rolesRepository,
            $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->form = $form;
        $this->service = $service;
        $this->formsRepository = $formsRepository;
        $this->rolesRepository = $rolesRepository;
    }
    
    public function run(int $formId, int $roleId) 
    {
        /** @var Form $form */
        /** @var ManagerRoles $role */
        $form = $this->formsRepository->findById($formId);
        $role = $this->rolesRepository->findById($roleId);
        $this->form->formId = $formId;
        $this->form->formName = $form->title . ':' . $form->name;
        $this->form->roleName = $role->name;
        $this->form->roleId = $role->id;
        if ($this->form->load(Yii::$app->request->post()) && $this->form->validate()) 
        {
            try {                
                $model = $this->service->create($this->form);
                return $this->controller->redirect(Url::previous());
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        
        return $this->controller->render('create',[
            'model' => $this->form
        ]);
    }
}
