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
        return "<div class=\"header__block\">
                <h4>{$field->name}</h4>
                <p class=\"description\">{$field->description}</p>
        <p class=\"info\">{$this->getParameters()['text']}</p>";        
    }

}
