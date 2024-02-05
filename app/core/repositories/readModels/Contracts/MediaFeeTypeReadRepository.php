<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\core\repositories\readModels\Contracts;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Contract\MediaFeeTypes;

/**
 * Description of MediaTypeReadRepository
 *
 * @author kotov
 */
class MediaFeeTypeReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return MediaFeeTypes::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
