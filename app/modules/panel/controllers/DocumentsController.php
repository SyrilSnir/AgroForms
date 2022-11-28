<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Documents\DocumentReadRepository;
use app\core\services\operations\Documents\DocumentService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Document\DocumentForm;
use app\models\SearchModels\Documents\ManagerDocumentSearch;

/**
 * Description of DocumentsController
 *
 * @author kotov
 */
class DocumentsController extends CrudController
{
    use GridViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            DocumentService $service,
            ManagerDocumentSearch $searchModel,
            DocumentReadRepository $repository,
            DocumentForm $form,
            $config = array()
            )
    {
        parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    }             
}
