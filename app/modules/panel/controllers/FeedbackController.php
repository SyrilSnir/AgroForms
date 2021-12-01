<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\FeedbackReadRepository;
use app\core\services\operations\FeedbackService;
use app\core\traits\GridViewTrait;
use app\models\SearchModels\FeedbackSearch;

/**
 * Description of FeedbackController
 *
 * @author kotov
 */
class FeedbackController extends BaseAdminController
{
    use GridViewTrait;
    /**
     * 
     * @var FeedbackService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            FeedbackService $service,
            FeedbackReadRepository $repository,
            FeedbackSearch $searchModel,
            $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->readRepository = $repository;
        $this->searchModel = $searchModel;
    }    
}
