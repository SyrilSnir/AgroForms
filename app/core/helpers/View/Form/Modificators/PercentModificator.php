<?php

namespace app\core\helpers\View\Form\Modificators;

/**
 * Description of PercentModificator
 *
 * @author kotov
 */
class PercentModificator extends PriceModificator
{
    //put your code here
    public function modify(int $price): int
    {
        $specialPrice = $this->getSpecialPriceElement();
        if ($specialPrice) {
            $price = $price + ($price * $specialPrice / 100);
        }        
        return $price;
    }
}
