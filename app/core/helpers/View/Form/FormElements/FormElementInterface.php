<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\helpers\View\Form\ExcelHeaderView;
use app\models\ActiveRecord\Forms\Field;

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
    
    public function getField(): Field;    
    
    public function getFieldId(): int;
    
    public function getOrder(): int;
    
    public function isShowInRequest():bool ;
    
    public function isShowInPdf():bool ;
    
    public function isExcelExport(): bool ;

    public function isComputed(): bool; 
    
    public function isDeleted(): bool;
    
    public function getLenght(): int;
    
    public function getExcelHeader(): ExcelHeaderView;
    
    public function getExcelValue(array $valuesList = []): array|string;
    
    public function setRequestId(int $requestId): void;
}
