<?php

namespace app\modules\panel\controllers\AccessRule;

use yii\base\Action;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
/**
 * Description of BaseController
 *
 * @author kotov
 */
class BaseController extends Controller implements DenyCallbackInterface
{
    /**
     * 
     * @var array Массив доступных ролей пользователя
     */
    protected $roles = ['@'];
    
    public function behaviors()
    {
        $controller = $this;
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->roles
                    ]  
                ],                
                'denyCallback' => function($rule, $action) { return static::isDenyAction($rule, $action); }
            ]
        ];                                
    }
    
    public static function isDenyAction($rule, Action $action) 
    {
        return $action->controller->redirect(Url::to('/panel/auth'));        
    }
}
