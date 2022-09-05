<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\helpers\View\Form\ExcelHeaderView;

/**
 *
 * @author kotov
 */
interface FormElementInterface
{
    public function getData(array $valuesList = []): array;
    
    public function renderHtml(array $valuesList = []): string;
    
    public function renderPDF(array $valuesList = []): string;
    
    public function getParameters():array;
    
    public function getFieldId(): int;
    
    public function getOrder(): int;
    
    public function isShowInRequest():bool ;
    public function isShowInPdf():bool ;

    public function isComputed(): bool; 
    
    public function isDeleted(): bool;
    
    public function getLenght(): int;
    
    public function getExcelHeader(): ExcelHeaderView;
    
    public function getExcelValue(array $valuesList = []): array;
}
