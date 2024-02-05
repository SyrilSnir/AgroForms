<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\core\repositories\manage\Contract;

use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Contract\MediaFeeTypes;
use app\core\repositories\exceptions\NotFoundException;
use yii\db\ActiveRecord;

/**
 * Description of MediaFeeTypeRepository
 *
 * @author kotov
 */
class MediaFeeTypeRepository implements RepositoryInterface
{
    use DataManipulationTrait;
       
    public function get(int $id): ActiveRecord
    {
        if (!$model = MediaFeeTypes::findOne($id)) {
            throw new NotFoundException('Элемент не найден');
        }
        return $model;
    }
}
