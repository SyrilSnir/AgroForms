<?php

namespace app\core\helpers\View\Form;

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
}
