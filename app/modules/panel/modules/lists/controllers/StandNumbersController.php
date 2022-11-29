<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Contracts\StandNumberReadRepository;
use app\core\services\operations\Contracts\StandNumberService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Contract\StandNumberForm;
use app\models\SearchModels\Contracts\StandNumberSearch;
use app\modules\panel\controllers\CrudController;

/**
 * Description of StandNumbersController
 *
 * @author kotov
 */
class StandNumbersController extends CrudController
{
    use GridViewTrait;    
    /**
     * 
     * @var StandNumberService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            StandNumberReadRepository $repository,
            StandNumberService $service,
            StandNumberSearch $searchModel,
            StandNumberForm $form,
            $config = array()
            )
    {
       parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    } 
}
