<?php

namespace app\modules\manage\modules\geography\controllers;

use app\core\repositories\readModels\Geography\CountryReadRepository;
use app\core\services\operations\Geography\CountryService;
use app\models\SearchModels\Geography\CountrySearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use Yii;

/**
 * Description of CountriesController
 *
 * @author kotov
 */
class CountriesController extends BaseAdminController
{
    /**
     *
     * @var CountryService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            CountryReadRepository $repository,
            CountryService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }  
    
    public function actionIndex() 
    {
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
