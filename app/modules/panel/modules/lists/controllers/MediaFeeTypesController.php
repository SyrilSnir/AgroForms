<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Contracts\MediaFeeTypeReadRepository;
use app\core\services\operations\Contracts\MediaFeeTypeService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Contract\MediaFeeTypeForm;
use app\models\SearchModels\Contracts\MediaFeeTypeSearch;
use app\modules\panel\controllers\CrudController;

/**
 * Description of MediaTypesController
 *
 * @author kotov
 */
class MediaFeeTypesController  extends CrudController
{
    use GridViewTrait;
    
    /**
     * 
     * @var MediaFeeTypeService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            MediaFeeTypeReadRepository $repository,
            MediaFeeTypeService $service,
            MediaFeeTypeSearch $searchModel,
            MediaFeeTypeForm $form,
            $config = array()
            )
    {
       parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    }     
}
