<?php

namespace app\modules\manage;

use app\modules\manage\modules\geography\Module as GeographyModule;
use app\modules\manage\modules\lists\Module as NomenclatureModule;
use app\modules\manage\modules\form\Module as FormModule;
use app\modules\manage\modules\member\Module as MemberModule;
use app\modules\manage\modules\config\Module as ConfigurationModule;
use yii\base\Module as BaseModule;
/**
 * Description of Module
 *
 * @author kotov
 */
class Module extends BaseModule
{
    public $controllerNamespace = 'app\modules\manage\controllers';

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
        ];
    }    
}
