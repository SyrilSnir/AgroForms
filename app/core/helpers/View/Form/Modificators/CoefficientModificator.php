<?php

namespace app\core\helpers\View\Form\Modificators;

/**
 * Description of CoefficientModificator
 *
 * @author kotov
 */
class CoefficientModificator extends PriceModificator
{
    //put your code here
    public function modify(int $price): int
    {
        $specialPrice = $this->getSpecialPriceElement();
        if ($specialPrice) {
            $price = $specialPrice->price * $price; 
        }        
        return $price;
    }

}
