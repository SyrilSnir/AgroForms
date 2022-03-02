<?php

namespace app\core\helpers\View\Form;

use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Requests\Request;

/**
 * Description of BaseFormHelper
 *
 * @author kotov
 */
abstract class BaseFormHelper
{
    /**
     * 
     * @var Form
     */
    protected $form;
    
    /**
     * 
     * @var Request|null
     */
    protected $request;
    
    /**
     * 
     * @var int
     */
    protected $userId;
    
    /**
     * 
     * @var string
     */
    protected $langCode;    
    
    protected function __construct(int $usetId, string $langCode) 
    {
        $this->userId = $usetId;
        $this->langCode = $langCode;        
    } 
    
    public abstract static function createViaForm(int $userId, string $langCode, Form $form): self;
    
    public abstract static function createViaRequest(int $userId, string $langCode, Request $request): self; 
    
    public abstract function renderHtmlRequest() :string;
    
    public abstract function getData(bool $isReadOnly = false) :array ;  
    
    public function isRequest():bool 
    {
        return !is_null($this->request);
    }      
}
