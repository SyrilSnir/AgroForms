<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\modules\requests\controllers;

use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\operations\Requests\RequestStandService;
use app\core\traits\GridViewTrait;
use app\core\traits\RequestViewTrait;
use app\models\SearchModels\Requests\ManagerStandSearch;
use app\modules\panel\controllers\BaseAdminController;

/**
 * Description of StandController
 *
 * @author kotov
 */
class StandController extends BaseAdminController
{
    use GridViewTrait, RequestViewTrait;  
    /**
     *
     * @var RequestStandService
     */
         
    protected $service;
        
    public function __construct(
            $id, 
            $module, 
            RequestReadRepository $repository,
            RequestStandService $service,
            ManagerStandSearch $searchModel,           
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }    
}
