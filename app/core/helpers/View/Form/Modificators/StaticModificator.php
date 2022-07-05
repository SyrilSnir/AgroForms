<?php

namespace app\core\helpers\View\Form\Modificators;

/**
 * Description of StaticModificator
 *
 * @author kotov
 */
class StaticModificator extends PriceModificator
{
    
    public function modify(int $price): int
    {
        $specialPrice = $this->getSpecialPriceElement();
        if ($specialPrice) {
            $price += $specialPrice->price; 
        }
        return $price;
    }

}
