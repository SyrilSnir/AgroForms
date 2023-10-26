<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Exhibition\CatalogReadRepository;
use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\Catalog\LoadRequestsService;
use app\core\services\operations\Exhibition\CatalogService;
use app\core\traits\GridViewTrait;
use app\models\Forms\CatalogLoadForm;
use app\models\Forms\Manage\Exhibition\CatalogForm;
use app\models\SearchModels\Exhibition\CatalogSearch;
use Yii;
use yii\helpers\Url;

/**
 * Description of CatalogController
 * 
 * @property CatalogService $service
 * @author kotov
 */
class CatalogController extends CrudController
{
    /**
     * 
     * @var RequestReadRepository
     */
    public $requestRepository;
    
    /**
     * 
     * @var LoadRequestsService
     */
    public $loadRequestsService;


    use GridViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            CatalogService $service, 
            CatalogSearch $searchModel,
            CatalogReadRepository $repository, 
            RequestReadRepository $requestRepository,
            LoadRequestsService $loadRequestsService,
            CatalogForm $form, 
            $config = [])
    {
        $this->searchModel = $searchModel;
        $this->requestRepository = $requestRepository;
        $this->loadRequestsService = $loadRequestsService;
        parent::__construct($id, $module, $service, $repository, $form, $config);
    }
    
    public function actionIndex() 
    {        
        Url::remember();
        
        $catalogLoadForm = new CatalogLoadForm();
        $dataProvider = $this->getDataProvider();
        $pageDataProvider = $this->configurePagination($dataProvider);
        return $this->render('index',[            
            'searchModel' => $this->searchModel,
            'dataProvider' => $pageDataProvider->getDataProvider(),
            'rowsCountForm' => $pageDataProvider->getRowsCountForm(),
            'pagination' => $this->showPagination,
            'catalogLoadForm' => $catalogLoadForm
        ]);
    }
    
    public function actionCatalogLoad()
    {
        $catalogLoadForm = new CatalogLoadForm();
        if ($catalogLoadForm->load(Yii::$app->request->post()) && $catalogLoadForm) {
            $requests = $this->requestRepository->findExportedRequests($catalogLoadForm->exhibitionId);
            if ($requests) {
                $this->service->clearForExhibition($catalogLoadForm->exhibitionId);
                $catalogRows = $this->loadRequestsService->getCatalogForms($requests);
                foreach ($catalogRows as $row) {
                    $this->service->create($row);
                }
                \Yii::$app->session->setFlash('success', t('Data loaded successfully'));
                        
                return Yii::$app->response->redirect(Url::previous());
            }
        }
        \Yii::$app->session->setFlash('error', t('No data to upload'));        
        return Yii::$app->response->redirect(Url::previous());
    }
        
}
