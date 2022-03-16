<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementImportantInformationBlock
 *
 * @author kotov
 */
class ElementImportantInformationBlock extends FormElement
{
    //put your code here
    public function renderHtml(array $valuesList = []): string
    {
        $field = $this->getField();
        return "<div class=\"important\">{$this->getTranslatableParameter('text')}</div>";        
    }

}
