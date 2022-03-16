<?php


namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementUnknown
 *
 * @author kotov
 */
class ElementUnknown extends FormElement
{
    public function renderHtml(array $valuesList = []): string {
        return '   <div class="block__undefined">
      <h2>Неизвестный тип блока</h2>
   </div>';
    }

}
