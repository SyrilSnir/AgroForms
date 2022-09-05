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
        <p class=\"info\">{$this->getTranslatableParameter('html')}</p>";        
    }

    public function renderPDF(array $valuesList = []): string 
    {
        $field = $this->getField();
        return "<tr style=\"border:none;\"><td colspan=\"2\">
                    <p style=\"font-family:Verdana;font-size:8pt;\">{$this->getTranslatableParameter('html')}</p>
                </td></tr>";       
    }
}
