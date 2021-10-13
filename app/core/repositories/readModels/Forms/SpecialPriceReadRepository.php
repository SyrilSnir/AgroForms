<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\SpecialPrice;

/**
 * Description of SpecialPriceReadRepository
 *
 * @author kotov
 */
class SpecialPriceReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return SpecialPrice::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}