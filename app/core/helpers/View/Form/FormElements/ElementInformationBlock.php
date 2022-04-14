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
        return "<tr style=\"border:none;\"><td>
                    <p style=\"font-family:Verdana;font-size:10pt;\">{$field->name}</p>
                    <p style=\"font-family:Verdana;font-size:7pt;\">{$field->description}</p>
                    <p style=\"font-family:Verdana;font-size:6pt;\">{$this->getTranslatableParameter('html')}</p>
                </td></tr>";       
    }

}
