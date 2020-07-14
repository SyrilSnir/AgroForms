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
     * @var UserIdentity
     */
    protected $user; 
    
    public function setUser(UserIdentity $user)
    {
        $this->user = $user;
    }
    
    public function setFormId(int $formId)
    {
        $this->formId = $formId;
    }
}
