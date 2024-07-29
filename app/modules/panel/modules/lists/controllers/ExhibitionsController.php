<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Exhibition\ExhibitionReadRepository;
use app\core\services\operations\Exhibition\ExhibitionService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use app\models\SearchModels\Exhibition\ExhibitionSearch;
use app\modules\panel\controllers\CrudController;
use kotchuprik\sortable\actions\Sorting;

/**
 * Description of ExhibitionsController
 *
 * @author kotov
 */
class ExhibitionsController extends CrudController
{
    use GridViewTrait;
    /**
     *
     * @var ExhibitionService 
     */
    protected $service;
    
    

    public function actions()
    {
        return [
            'sorting' => [
                'class' => Sorting::class,
                'query' => Exhibition::find(),
           ],           
        ];
    }
    
    public function __construct(
            $id, 
            $module, 
            ExhibitionReadRepository $repository,
            ExhibitionService $service,
            ExhibitionSearch $searchModel,
            ExhibitionForm $form,            
            $config = array()
            )
    {
        parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    }          
}
