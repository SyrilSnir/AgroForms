<?php

namespace app\models\Data;

/**
 * Description of SpecialPriceTypes
 *
 * @author kotov
 */
class SpecialPriceTypes 
{
    /**
     * Рассчет по фисксированной сумме
     */
    const TYPE_VALUTE = 0; 
    
    /**
     * Расчет в процентах %
     */
    const TYPE_PERCENT = 1;
    
    /**
     * Расчет по коэффициенту
     */
    const TYPE_COEFFICIENT = 2;
}
