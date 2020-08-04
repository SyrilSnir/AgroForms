<?php

namespace app\modules\manage\modules\lists\controllers;

use app\core\repositories\readModels\Requests\RequestReadRepository;
use app\core\services\operations\Requests\RequestService;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ChangeStatusForm;
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
    
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /** @var Request $model */
        $model = $this->findModel($id);
        $statusForm = new ChangeStatusForm($model->id, $model->status);
        if ($statusForm->load(\Yii::$app->request->post()) && $statusForm->validate()) {
            $model = $this->service->changeStatus($statusForm);
            \Yii::$app->session->setFlash('success','Статус заявки успешно изменен');            
        }
        return $this->render('view', [
            'model' => $model,
            'statusForm' => $statusForm
        ]);
    }    
    
    public function actionExport(int $id)
    {
        /** @var Request $request */
        $request = $this->readRepository->findById($id);
        $template = null;
        $formTitle = '';
        switch ($request->form->form_type_id)
        {
            case FormType::SPECIAL_STAND_FORM:
                $template = 'stand';
                $formTitle = 'Заявка №2 : Стандартный стенд';
                $content = $this->renderPartial('@pdf/requests/'. $template,[
                    'request' => $request 
                ]);                
                break;
            case FormType::DYNAMIC_INFORMATION_FORM:
            case FormType::DYNAMIC_ORDER_FORM:
                $template = 'dynamic-form';
                $formTitle = $request->form->title .' : '. $request->form->name;
                $content = $this->renderPartial('@pdf/requests/'. $template,[
                    'request' => $request 
                ]);                  
                break;
        }
    // get your HTML raw content without any layouts or scripts
       
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
