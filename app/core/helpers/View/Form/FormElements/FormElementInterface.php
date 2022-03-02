<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 *
 * @author kotov
 */
interface FormElementInterface
{
    public function getData(array $valuesList = []): array;
    
    public function renderHtml(array $valuesList = []): string;
    
    public function getParameters():array;
    
    public function getFieldId(): int;
    
    public function getOrder(): int;
    
    public function isShowInRequest():bool ;
}
