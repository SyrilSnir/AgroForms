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
        return "<div class=\"section__important\">{$this->getTranslatableParameter('text')}</div>";        
    }

    public function renderPDF(array $valuesList = []): string
    {   
        return '<tr><td colspan="2" style="color:black;font-family:Verdana;font-size:10pt;text-align:center;border:1px solid black; padding:10px">' .$this->getTranslatableParameter('text') . '</td></tr>';
    }

}
