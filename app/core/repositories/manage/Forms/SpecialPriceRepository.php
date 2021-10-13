<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\models\ActiveRecord\Forms\SpecialPrice;
use yii\db\ActiveRecord;

/**
 * Description of SpecialPriceRepository
 *
 * @author kotov
 */
class SpecialPriceRepository
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = SpecialPrice::findOne($id)) {
            throw new NotFoundException('Object model not found');
        }
        return $model;
    }
}
