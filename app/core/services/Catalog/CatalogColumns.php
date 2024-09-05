<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

namespace app\core\services\Catalog;

/**
 *
 * @author kotov
 */
interface CatalogColumns
{
    const COLUMN_NAME = 1;
    const COLUMN_NAME_ENG = 2;
    
    const COLUMN_STAND = 3;
    const COLUMN_STAND_ENG = 4;
    
    const COLUMN_DESCRIPTION = 5;
    const COLUMN_DESCRIPTION_ENG = 6;
    
    const COLUMN_COUNTRY = 7;
    const COLUMN_COUNTRY_ENG = 8;
    
    const COLUMN_REGION = 9;
    const COLUMN_REGION_ENG = 10;
    
    const COLUMN_CITY = 11;
    const COLUMN_CITY_ENG = 12;
    
    const COLUMN_ADDRESS = 13;
    const COLUMN_ADDRESS_ENG = 14;
    
    const COLUMN_INDEX = 15;
    
    const COLUMN_FULL_ADDRESS = 16;
    const COLUMN_FULL_ADDRESS_ENG = 17;
    
    const COLUMN_FULL_ADDRESS_WITHOUT_COUNTRY = 18;
    const COLUMN_FULL_ADDRESS_WITHOUT_COUNTRY_ENG = 19;
    
    const COLUMN_PHONES = 20;
    const COLUMN_FAXES = 21;
    const COLUMN_EMAILS = 22;
    const COLUMN_SITES = 23;
    
    const COLUMN_CATEGORIES = 24;
    const COLUMN_CATEGORIES_ENG = 25;
    
    const COLUMN_PARENT_CATEGORIES = 26;
    const COLUMN_PARENT_CATEGORIES_ENG = 27;
    
    const COLUMN_FIRST_LETTER = 28;
    const COLUMN_FIRST_LETTER_ENG = 29;
    
    const COLUMN_LOGO_FILE = 30;
    const COLUMN_CATALOG_FILE = 31;
               
    const COLUMN_BRANDS = 32;
    const COLUMN_BRANDS_ENG = 33; 
}
