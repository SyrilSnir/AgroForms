<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Exhibition\CatalogReadRepository;
use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\Catalog\ExportService;
use app\core\services\Catalog\LoadRequestsService;
use app\core\services\operations\Exhibition\CatalogService;
use app\core\services\operations\Exhibition\ExhibitionService;
use app\core\traits\GridViewTrait;
use app\models\ActiveRecord\Exhibition\Catalog;
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
    
    /**
     * 
     * @var ExportService
     */
    private $exportService;
    
    /**
     * 
     * @var ExhibitionService
     */
    private $exhibitionService;

    use GridViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            CatalogService $service, 
            CatalogSearch $searchModel,
            CatalogReadRepository $repository, 
            RequestReadRepository $requestRepository,
            LoadRequestsService $loadRequestsService,
            ExportService $exportService,
            ExhibitionService $exhibitionService,
            CatalogForm $form, 
            $config = [])
    {
        $this->searchModel = $searchModel;
        $this->requestRepository = $requestRepository;
        $this->loadRequestsService = $loadRequestsService;
        $this->exportService = $exportService;
        $this->exhibitionService = $exhibitionService;
        parent::__construct($id, $module, $service, $repository, $form, $config);
    }
    
    public function actionIndex() 
    {        
        Url::remember();
        $currentExhibitionId = $this->exhibitionService->getActiveExhibition();        
        $catalogLoadForm = new CatalogLoadForm();
        $dataProvider = $this->getDataProvider();
        $pageDataProvider = $this->configurePagination($dataProvider);
        return $this->render('index',[            
            'searchModel' => $this->searchModel,
            'dataProvider' => $pageDataProvider->getDataProvider(),
            'rowsCountForm' => $pageDataProvider->getRowsCountForm(),
            'pagination' => $this->showPagination,
            'catalogLoadForm' => $catalogLoadForm,
            'currentExhibitionId' => $currentExhibitionId,
        ]);
    }
    
    public function actionCatalogLoad()
    {
        $catalogLoadForm = new CatalogLoadForm();        
        if ($catalogLoadForm->load(Yii::$app->request->post()) && $catalogLoadForm) {
            $requests = $this->requestRepository->findExportedRequests($catalogLoadForm->exhibitionId);
            $this->service->clearForExhibition($catalogLoadForm->exhibitionId);
            if ($requests) {                
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
    
    public function actionExcel(int $exhibitionId = null) 
    {
        if (empty($exhibitionId)) {
            return $this->refreshWithError('Не выбрана выставка');
        }
        $catalogElements = Catalog::find()
                ->andWhere(['exhibition_id' => $exhibitionId])
                ->orderBy(['company' => SORT_ASC,'company_eng' => SORT_ASC])
                ->all();
        if (empty($catalogElements)) {
            return $this->refreshWithError('Не найдено записей каталога');
        }
        $this->exportService->catalogToExcel($catalogElements);
    }
    
    /**
     * 
     * @param string $message
     * @return type
     */
    private function refreshWithError(string $message) 
    {
            \Yii::$app->session->setFlash('error', $message);
            return Yii::$app->response->redirect(Url::previous());        
    }            
}
