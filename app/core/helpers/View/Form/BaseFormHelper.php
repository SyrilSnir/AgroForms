<?php

namespace app\core\helpers\View\Form;

use app\models\ActiveRecord\Contract\Contracts;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Users\User;
use kartik\mpdf\Pdf;
use Yii;

/**
 * Description of BaseFormHelper
 *
 * @author kotov
 */
abstract class BaseFormHelper
{
    
    use FormElementsManagementTrait;
    /**
     * 
     * @var Form
     */
    protected $form;
      
    /**
     * 
     * @var User
     */
    protected $user;
    
    /**
     * 
     * @var string
     */
    protected $langCode;
    
    /**
     * 
     * @var Pdf
     */
    protected $pdfHelper;


    protected function __construct(User $user, string $langCode) 
    {
        $this->user = $user;
        $this->langCode = $langCode;    
        $this->pdfHelper = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            'defaultFont' => 'Verdana',
            'defaultFontSize' => '10',
            // portrait orientation            
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
        //    'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
           // 'cssInline' => '.kv-heading-1{font-size:18px};.headtext{color:red}',   
           // 'options' => ['title' => ''],
            ]
        );
        $this->pdfHelper->getApi()->defaultfooterline = 0;
        $this->pdfHelper->getApi()->setAutoBottomMargin = 'stretch';
    } 
    
    public abstract static function createViaForm(User $user, Contracts $contract, string $langCode, Form $form): self;
    
    public abstract static function createViaRequest(User $user, Contracts $contract, string $langCode, Request $request): self; 
    
    public abstract function renderHtmlRequest(): string;
    
    public abstract function renderPDF(): mixed;

    public abstract function getData() :array ;  
    
    public abstract function getFormPrice() :int ; 
    
    public abstract function getPrintedElementsCount(): int;    

    public abstract function getExcelHeader(): array;        
    
    protected function getPdfHeader(): string   
    {
        return  Yii::$app->view->renderFile('@pdf/request-header.php',[
            'exhibitionName' => $this->form->exhibition->title,
            'contractNumber' => $this->getContractNumber(),
            'dateOfContract' => $this->getContractDate(),
        ]);
    }
           
    protected function getPdfFooter(): string
    {        
        return  Yii::$app->view->renderFile('@pdf/request-footer.php',[
            'request' => $this->request
        ]);
    }
    
    public function removeRequest(): void
    {
        $this->request = null;        
    }
}
