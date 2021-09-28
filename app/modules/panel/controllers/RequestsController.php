<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\traits\GridViewTrait;
use app\core\traits\RequestViewTrait;
use app\models\SearchModels\Requests\ManagerRequestSearch;

/**
 * Description of RequestController
 *
 * @author kotov
 */
class RequestsController extends BaseAdminController
{
    use GridViewTrait,RequestViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            ManagerRequestSearch $searchModel,
            RequestReadRepository $repository,            
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
     //   $this->readRepository = $repository;
    //    $this->service = $service;
        $this->searchModel = $searchModel;
        $this->readRepository = $repository;
    }        
}
