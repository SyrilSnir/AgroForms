<?php

namespace app\modules\panel;

use app\modules\panel\modules\geography\Module as GeographyModule;
use app\modules\panel\modules\lists\Module as NomenclatureModule;
use app\modules\panel\modules\form\Module as FormModule;
use app\modules\panel\modules\member\Module as MemberModule;
use app\modules\panel\modules\config\Module as ConfigurationModule;
use app\modules\panel\modules\manager\Module as ManagerModule;
use app\modules\panel\modules\requests\Module as RequestsModule;
use yii\base\Module as BaseModule;
/**
 * Description of Module
 *
 * @author kotov
 */
class Module extends BaseModule
{
    public $controllerNamespace = 'app\modules\panel\controllers';

    public function init()
    {
        parent::init();
        $this->modules = [
            'geography' => [
                'class' => GeographyModule::class,
            ],
            'lists' => [
                'class' => NomenclatureModule::class,
            ],
            'form' => [
                'class' => FormModule::class,
            ],
             'member' => [
                'class' => MemberModule::class,
            ],  
            'config' => [
                   'class' => ConfigurationModule::class,
            ],
            'manager' => [
                   'class' => ManagerModule::class,
            ],                      
        ];
    }    
}
