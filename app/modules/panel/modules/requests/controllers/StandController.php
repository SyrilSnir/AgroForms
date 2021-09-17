<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\modules\requests\controllers;

use app\core\repositories\readModels\Requests\RequestStandReadRepository;
use app\core\services\operations\Requests\RequestStandService;
use app\core\services\operations\View\Requests\RequestStandViewService;
use app\core\traits\GridViewTrait;
use app\models\SearchModels\Requests\RequestStandSearch;
use app\modules\panel\controllers\BaseAdminController;

/**
 * Description of StandController
 *
 * @author kotov
 */
class StandController extends BaseAdminController
{
    use GridViewTrait;    
    /**
     *
     * @var RequestStandService
     */
    protected $service;
    /**
     *
     * @var RequestStandViewService
     */
    private $standViewService;
    
    public function __construct(
            $id, 
            $module, 
            RequestStandReadRepository $repository,
            RequestStandService $service,
            RequestStandSearch $searchModel,
            RequestStandViewService $requestStandViewService,            
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
        $this->searchModel = $searchModel;
        $this->standViewService = $requestStandViewService;
    }    
}
