<?php

namespace app\core\services\Catalog;

use app\models\ActiveRecord\Exhibition\Catalog;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Description of ExportService
 *
 * @author kotov
 */
class ExportService
{
    /**
     * 
     * @var Spreadsheet
     */
    private $spreadSheet;
    
    /**
     * 
     * @var Worksheet
     */
    private $activeSheet;


    /**
     * 
     * @var Xlsx
     */
    private $xlsWriter;
    
    private $columnsCount = 31;
    
    public function __construct(Spreadsheet $spreadSheet)
    {
        $this->spreadSheet = $spreadSheet;
        $this->xlsWriter = new Xlsx($spreadSheet);
        $this->activeSheet = $this->spreadSheet->getActiveSheet();
    }

    /**
     * 
     * @param Catalog[] $catalogElements
     */
    public function catalogToExcel(array $catalogElements) 
    {        
        $this->setHeaders();
        $this->initPage();
        $this->prepareExcelHeader(); 
        $rowsCount = $this->putCatalogData($catalogElements);
        $this->postprocessExcel($rowsCount);
        $this->xlsWriter->save('php://output');
        die();
        
    }
    
    private function setHeaders() 
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=ANSI');                                
        header('Content-Disposition: attachment;filename="catalog' .date('d.m.Y').'.xlsx"');
        header('Cache-Control: max-age=0');         
    }
    
    private function initPage()
    {
        $this->spreadSheet->setActiveSheetIndex(0);
        $this->activeSheet->setTitle('Каталог участников');
    }
    
    private function prepareExcelHeader() 
    {
        for($colIdx = 1; $colIdx <= $this->columnsCount; $colIdx++) 
        {
            $title = '';
            switch ($colIdx) {
                case CatalogColumns::COLUMN_NAME:
                    $title = 'Название';
                    break;
                case CatalogColumns::COLUMN_NAME_ENG:
                    $title = 'Name';
                    break;
                case CatalogColumns::COLUMN_STAND:
                    $title = 'Стенд';
                    break;
                case CatalogColumns::COLUMN_STAND_ENG:
                    $title = 'Booth';
                    break;
                case CatalogColumns::COLUMN_DESCRIPTION:
                    $title = 'Описание';
                    break;
                case CatalogColumns::COLUMN_DESCRIPTION_ENG:
                    $title = 'Description';
                    break;
                case CatalogColumns::COLUMN_COUNTRY:
                    $title = 'Страна';
                    break;
                case CatalogColumns::COLUMN_COUNTRY_ENG:
                    $title = 'Country';
                    break;
                case CatalogColumns::COLUMN_REGION:
                    $title = 'Область, район';
                    break;
                case CatalogColumns::COLUMN_REGION_ENG:
                    $title = 'Region';
                    break;
                case CatalogColumns::COLUMN_CITY:
                    $title = 'Город';
                    break;
                case CatalogColumns::COLUMN_CITY_ENG:
                    $title = 'City';
                    break;
                case CatalogColumns::COLUMN_ADDRESS:
                    $title = 'Адрес';
                    break;
                case CatalogColumns::COLUMN_ADDRESS_ENG:
                    $title = 'Address';
                    break;
                case CatalogColumns::COLUMN_INDEX:
                    $title = 'Индекс';
                    break;
                case CatalogColumns::COLUMN_FULL_ADDRESS:
                    $title = 'Полный адрес';
                    break;
                case CatalogColumns::COLUMN_FULL_ADDRESS_ENG:
                    $title = 'Full address';
                    break;
                case CatalogColumns::COLUMN_FULL_ADDRESS_WITHOUT_COUNTRY:
                    $title = 'Полный адрес без страны';
                    break;
                case CatalogColumns::COLUMN_FULL_ADDRESS_WITHOUT_COUNTRY_ENG:
                    $title = 'Full address without country';
                    break;
                case CatalogColumns::COLUMN_PHONES:
                    $title = 'Телефоны';
                    break;
                case CatalogColumns::COLUMN_FAXES:
                    $title = 'Факсы';
                    break;
                case CatalogColumns::COLUMN_EMAILS:
                    $title = 'Emails';
                    break;
                case CatalogColumns::COLUMN_SITES:
                    $title = 'Sites WWW';
                    break;
                case CatalogColumns::COLUMN_CATEGORIES:
                    $title = 'Категории';
                    break;
                case CatalogColumns::COLUMN_CATEGORIES_ENG:
                    $title = 'Categories';
                    break;
                case CatalogColumns::COLUMN_PARENT_CATEGORIES:
                    $title = 'Родительские категории';
                    break;
                case CatalogColumns::COLUMN_PARENT_CATEGORIES_ENG:
                    $title = 'Parent categories';
                    break;
                case CatalogColumns::COLUMN_FIRST_LETTER:
                    $title = 'Первая буква';
                    break;
                case CatalogColumns::COLUMN_FIRST_LETTER_ENG:
                    $title = 'First letter';
                    break;
                case CatalogColumns::COLUMN_IS_LOGO_PRESENTED:
                    $title = 'Есть логотип';
                    break;
                case CatalogColumns::COLUMN_BRANDS:
                    $title = 'Бренды';
                    break;
                case CatalogColumns::COLUMN_BRANDS_ENG:
                    $title = 'Brands';
                    break;
            }  
            $this->activeSheet->setCellValue([$colIdx, 1], $title);
        }        
    }
    
    /**
     * 
     * @param Catalog[] $catalogElements
     */
    private function putCatalogData(array $catalogElements)
    {
        $rowIndex = 2;
        $testLimiter = 5;
        foreach ($catalogElements as $el) {
            for($colIdx = 1; $colIdx <= $this->columnsCount; $colIdx++) {
                $rowData = '';
                switch ($colIdx) {
                case CatalogColumns::COLUMN_NAME:
                    $rowData = $el->company;
                    break;
                case CatalogColumns::COLUMN_NAME_ENG:
                    $rowData = $el->company_eng;
                    break;
                case CatalogColumns::COLUMN_STAND:
                    $rowData = $el->stand;
                    break;
                case CatalogColumns::COLUMN_STAND_ENG:
                    $rowData = $el->stand;
                    break;
                case CatalogColumns::COLUMN_DESCRIPTION:
                    $rowData = $el->description;
                    break;
                case CatalogColumns::COLUMN_DESCRIPTION_ENG:
                    $rowData = $el->description_eng;
                    break;
                case CatalogColumns::COLUMN_COUNTRY:
                    $rowData = $el->getCountryNames();
                    break;
                case CatalogColumns::COLUMN_COUNTRY_ENG:
                    $rowData = $el->getCountryNamesEng();
                    break;
                case CatalogColumns::COLUMN_REGION:
                    $rowData = $el->getRegionNames();
                    break;
                case CatalogColumns::COLUMN_REGION_ENG:
                    $rowData = $el->getRegionNames();
                    break;
                case CatalogColumns::COLUMN_CITY:
                    $rowData = $el->getCityNames();
                    break;
                case CatalogColumns::COLUMN_CITY_ENG:
                    $rowData = $el->getCityNamesEng();
                    break;
                case CatalogColumns::COLUMN_ADDRESS:
                    $rowData = $el->getAddressText();
                    break;
                case CatalogColumns::COLUMN_ADDRESS_ENG:
                    $rowData = $el->getAddressTextEng();
                    break;
                case CatalogColumns::COLUMN_INDEX:
                    $rowData = $el->getIndexes();
                    break;
                case CatalogColumns::COLUMN_FULL_ADDRESS:
                    $rowData = $el->getFullAddressText();
                    break;
                case CatalogColumns::COLUMN_FULL_ADDRESS_ENG:
                    $rowData = $el->getFullAddressTextEng();
                    break;
                case CatalogColumns::COLUMN_FULL_ADDRESS_WITHOUT_COUNTRY:
                    $rowData = $el->getFullAddressWithoutCountry();
                    break;
                case CatalogColumns::COLUMN_FULL_ADDRESS_WITHOUT_COUNTRY_ENG:
                    $rowData = $el->getFullAddressWithoutCountryEng();
                    break;
                case CatalogColumns::COLUMN_PHONES:
                    $rowData = $el->getPhones();
                    break;
                case CatalogColumns::COLUMN_FAXES:
                    $rowData = '';
                    break;
                case CatalogColumns::COLUMN_EMAILS:
                    $title = $el->getEmails();
                    break;
                case CatalogColumns::COLUMN_SITES:
                    $title = $el->getSites();
                    break;
                case CatalogColumns::COLUMN_CATEGORIES:
                    $rowData = $el->getCategories();
                    break;
                case CatalogColumns::COLUMN_CATEGORIES_ENG:
                    $rowData = $el->getCategoriesEng();
                    break;
                case CatalogColumns::COLUMN_PARENT_CATEGORIES:
                    $rowData= $el->getParentCategories();
                    break;
                case CatalogColumns::COLUMN_PARENT_CATEGORIES_ENG:
                    $rowData = $el->getParentCategoriesEng();
                    break;
                case CatalogColumns::COLUMN_FIRST_LETTER:
                    $rowData = '('. mb_substr(trim(mb_convert_case($el->company, MB_CASE_TITLE)),0,1) . ')';
                    break;
                case CatalogColumns::COLUMN_FIRST_LETTER_ENG:
                    $rowData = '('. mb_substr(trim(mb_convert_case($el->company_eng, MB_CASE_TITLE)),0,1) . ')';
                    break;
                case CatalogColumns::COLUMN_IS_LOGO_PRESENTED:
                    $rowData = $el->logo_file ? 'Да' : 'Нет';
                    break;
                case CatalogColumns::COLUMN_BRANDS:
                    $rowData = '';
                    break;
                case CatalogColumns::COLUMN_BRANDS_ENG:
                    $rowData = '';
                    break;                    
                    
                }
                $this->activeSheet->setCellValue([$colIdx, $rowIndex], $rowData);
            }
            $rowIndex++;
            if ($testLimiter <= $rowIndex) break;
        }
        return $rowIndex;
    }
    
    protected function postprocessExcel(int $rowsCount) 
    {
        $borderStyle = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                
                            ],
                        ],
                    ];
        $headerBGColor = 'dbdbdb';    
        $this->activeSheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->activeSheet->getStyle("A1:A$this->columnsCount")->getFont()->setBold(true);
        $this->activeSheet->getStyle([1,1, $this->columnsCount,$rowsCount-1])->applyFromArray($borderStyle);
        $this->activeSheet->getStyle([1,1, $this->columnsCount,1])
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB($headerBGColor);
        
        
        $this->activeSheet->getColumnDimensionByColumn(CatalogColumns::COLUMN_DESCRIPTION)->setWidth(50);
        $this->activeSheet->getColumnDimensionByColumn(CatalogColumns::COLUMN_DESCRIPTION_ENG)->setWidth(50);
        $this->activeSheet->getStyle(Coordinate::stringFromColumnIndex(CatalogColumns::COLUMN_DESCRIPTION))->getAlignment()->setWrapText(true);
        $this->activeSheet->getStyle(Coordinate::stringFromColumnIndex(CatalogColumns::COLUMN_DESCRIPTION_ENG))->getAlignment()->setWrapText(true);
    }
        
}
