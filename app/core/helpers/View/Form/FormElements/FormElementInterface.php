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
    
    public function isEmpty(array $valuesList = []): bool;
    
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
    
    public function isGroup():bool;
    
    public function getExcelHeader(): ExcelHeaderView;
    
    public function getExcelValue(array $valuesList = []): array|string;
    
    public function setRequestId(int $requestId): void;
    
    public function getCatalogData(array $valuesList): array;
    
    public function getElements(): array;
}
