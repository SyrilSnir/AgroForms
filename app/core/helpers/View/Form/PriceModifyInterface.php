<?php

namespace app\core\helpers\View\Form;

use app\models\ActiveRecord\Forms\SpecialPrice;

/**
 *
 * @author kotov
 */
interface PriceModifyInterface
{
    /**
     * Изменение стоимости
     * @param int $price
     * @return int
     */
    public function modify(int $price): int;   
    
    public function getAlias(): string;
    
    public function getSpecialPriceElement(): ?SpecialPrice;    
}
