<?php

namespace app\modules\panel\controllers;

use app\modules\panel\controllers\AccessRule\BaseAdminController;
use app\core\services\operations\Forms\FieldEnumService;

/**
 * Description of FieldEnumController
 *
 * @author kotov
 */
class FieldEnumController extends BaseAdminController
{
    /**
     *
     * @var FieldEnumService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            FieldEnumService $fieldEnumService,
            $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $fieldEnumService;
    }
}
