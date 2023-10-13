<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Forms\FieldLabelsReadRepository;
use app\core\services\operations\Forms\FieldLabelService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Forms\FieldLabelForm;
use app\models\SearchModels\Forms\FieldLabelsSearch;
use app\modules\panel\controllers\CrudController;

/**
 * Description of FieldLabelsController
 *
 * @author kotov
 */
class FieldLabelsController extends CrudController
{
    use GridViewTrait; 
     /**
     * 
     * @var FieldLabelService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            FieldLabelsReadRepository $repository,
            FieldLabelService $service,
            FieldLabelsSearch $searchModel,
            FieldLabelForm $form,
            $config = array()
            )
    {
       parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    }
    
    
}
