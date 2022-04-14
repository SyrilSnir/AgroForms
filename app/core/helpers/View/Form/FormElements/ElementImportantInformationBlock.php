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

    public function renderPDF(array $valuesList = []): string
    {   
        return '<tr><td colspan="2" style="font-family:Verdana;font-size:10pt;text-align:left">' .$this->getTranslatableParameter('text') . '</td></tr>';
    }

}
