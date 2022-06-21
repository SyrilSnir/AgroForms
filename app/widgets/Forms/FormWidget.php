<?php

namespace app\widgets\Forms;

use app\core\manage\Auth\UserIdentity;
use app\models\ActiveRecord\Forms\Form;
use yii\base\Widget;

/**
 * Description of FormWidget
 *
 * @author kotov
 */
abstract class FormWidget extends Widget
{
    
    /**
     *
     * @var int
     */
    protected $formId;
              
    /**
     *
     * @var int
     */
    protected $contractId;    
    /**
     *
     * @var UserIdentity
     */
    protected $user; 
    
    /**
     * 
     * @var bool
     */
    protected $readOnly;
    
    public function setUser(UserIdentity $user): void 
    {
        $this->user = $user;
    }
    
    public function setFormId(int $formId): void 
    {
        $this->formId = $formId;
    }
    
    public function setReadOnly(bool $val): void 
    {
        $this->readOnly = $val;
    }
    
    public function setContractId(int $contractId): void 
    {
        $this->contractId = $contractId;
    }


}
