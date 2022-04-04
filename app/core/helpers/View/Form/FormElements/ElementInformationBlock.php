<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementInformationBlock
 *
 * @author kotov
 */
class ElementInformationBlock extends FormElement
{
    //put your code here
    public function renderHtml(array $valuesList = []): string
    {
        $field = $this->getField();
        return "<div class=\"header__block\">
                <h4>{$field->name}</h4>
                <p class=\"description\">{$field->description}</p>
        <p class=\"info\">{$this->getTranslatableParameter('html')}</p>";        
    }

    public function renderPDF(array $valuesList = []): string 
    {
        $field = $this->getField();
        return "<div class=\"header__block\">
                <h4>{$field->name}</h4>
                <p class=\"description\">{$field->description}</p>
        <p class=\"info\">{$this->getTranslatableParameter('html')}</p>";          
    }

}
