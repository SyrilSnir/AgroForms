<?php

namespace app\core\helpers\View\Form;

use app\models\ActiveRecord\Requests\Request;

/**
 *
 * @author kotov
 */
trait FormElementsManagementTrait
{
    /**
     * 
     * @var Request|null
     */
    protected $request;
    
    public function getRequest(): ?Request
    {
        return $this->request;
    }
    
    public function isRequest():bool 
    {
        return !is_null($this->request);
    }    
}
