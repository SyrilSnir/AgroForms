<?php

namespace app\core\helpers\View\Form\FormElements;

use app\models\ActiveRecord\Forms\Field;
/**
 * Description of FormElement
 *
 * @author kotov
 */
abstract class FormElement implements FormElementInterface
{
    /**
     * 
     * @var Field
     */
    protected $field;
}
