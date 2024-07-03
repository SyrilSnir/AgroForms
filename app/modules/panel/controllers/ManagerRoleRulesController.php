<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\User\ManagerRoleRulesReadRepository;
use app\core\services\operations\Users\ManagerRoleRulesService;
use app\models\Forms\Manage\Users\ManagerRoleRulesForm;
use app\modules\panel\controllers\Actions\CreateRuleAction;
use DomainException;
use Yii;
use yii\helpers\Url;

/**
 * Description of ManagerRoleRules
 *
 * @author kotov
 */
class ManagerRoleRulesController extends CrudController
{
    /**
     *
     * @var ManagerRoleRulesService
     */
    protected $service;    

    public function __construct(
            $id, 
            $module, 
            ManagerRoleRulesReadRepository $repository,
            ManagerRoleRulesService $service,
            ManagerRoleRulesForm $form,
            $config = array()
            )
    {
        parent::__construct($id, $module,$service,$repository,$form, $config);
    } 
    
    public function actions(): array
    {
        return [
            'create' => CreateRuleAction::class
        ];
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
        return $this->redirect(Url::previous());
    }    
}
