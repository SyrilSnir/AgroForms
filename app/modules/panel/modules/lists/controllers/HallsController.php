<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Contracts\HallReadRepository;
use app\core\services\operations\Contracts\HallService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Contract\HallForm;
use app\models\SearchModels\Contracts\HallSearch;
use app\modules\panel\controllers\CrudController;

/**
 * Description of HallsController
 *
 * @author kotov
 */
class HallsController extends CrudController
{
    use GridViewTrait;    
    /**
     * 
     * @var HallService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            HallReadRepository $repository,
            HallService $service,
            HallSearch $searchModel,
            HallForm $form,
            $config = array()
            )
    {
       parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    }     
}
