<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Contracts\ContractReadRepository;
use app\core\services\operations\Contracts\ContractService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Contract\ContractForm;
use app\models\SearchModels\Contracts\ContractSearch;

/**
 * Description of ContractsController
 *
 * @author kotov
 */
class ContractsController extends CrudController
{
    use GridViewTrait;
    
    /**
     *
     * @var ContractService
     */
    protected $service;

    public function __construct(
            $id, 
            $module, 
            ContractReadRepository $repository,
            ContractService $service,
            ContractSearch $searchModel,
            ContractForm $form,
            $config = array()
            )
    {
       parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    }     
}
