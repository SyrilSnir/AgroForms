<?php

namespace app\modules\manage\modules\lists\controllers;

use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\operations\Requests\RequestService;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\Requests\RequestSearch;
use app\modules\manage\controllers\AccessRule\BaseAdminController;
use kartik\mpdf\Pdf;
use Yii;

/**
 * Description of RequestsController
 *
 * @author kotov
 */
class RequestsController extends BaseAdminController
{

    /**
     *
     * @var RequestService
     */
    protected $service;
    
    public function __construct(
            $id, 
            $module, 
            RequestReadRepository $repository,
            RequestService $service,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->service = $service;
    }
    public function actionIndex()
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->searchForManager(
                Yii::$app->request->queryParams
            );        
        return $this->render('index',[            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionExport(int $id)
    {
        /** @var Request $request */
        $request = $this->readRepository->findById($id);
        $template = null;
        $formTitle = '';
        switch ($request->form_type_id)
        {
            case FormType::SPECIAL_STAND_FORM:
                $template = 'stand';
                $formTitle = 'Заявка №2 : Стандартный стенд';
                break;
        }
    // get your HTML raw content without any layouts or scripts
       $content = $this->renderPartial('@pdf/requests/stand',[
           'request' => $request 
       ]);
       
       $cssInline = <<<CSS
.kv-heading-1
    {
        font-size:18px
    }         
CSS;
       // setup kartik\mpdf\Pdf component
       $pdf = new Pdf([
           // set to use core fonts only
           'mode' => Pdf::MODE_UTF8, 
           // A4 paper format
           'format' => Pdf::FORMAT_A4, 
           // portrait orientation
           'orientation' => Pdf::ORIENT_PORTRAIT, 
           // stream to browser inline
           'destination' => Pdf::DEST_BROWSER, 
           // your html content input
           'content' => $content,  
           // format content from your own css file if needed or use the
           // enhanced bootstrap css built by Krajee for mPDF formatting 
           'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
           // any css to be embedded if required
           'cssInline' => $cssInline, 
            // set mPDF properties on the fly
           'options' => ['title' => 'Заявка на выставку Агросалон 2020'],
            // call mPDF methods on the fly
           'methods' => [ 
               'SetHeader'=>[$formTitle], 
               'SetFooter'=>['{PAGENO}'],
           ]
       ]);
     // return $content;
       return $pdf->render(); 
    }
    
}
