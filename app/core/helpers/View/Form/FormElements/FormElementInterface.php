<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 *
 * @author kotov
 */
interface FormElementInterface
{
    public function getData(): array;
    
    public function renderHtml(): string;
}
