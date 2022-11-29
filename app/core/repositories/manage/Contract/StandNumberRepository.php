<?php

namespace app\core\repositories\manage\Contract;

use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Contract\StandNumber;
use Mpdf\Container\NotFoundException;
use yii\db\ActiveRecord;

/**
 * Description of StandNumberRepository
 *
 * @author kotov
 */
class StandNumberRepository implements RepositoryInterface
{
    use DataManipulationTrait;
       
    public function get(int $id): ActiveRecord
    {
        if (!$model = StandNumber::findOne($id)) {
            throw new NotFoundException('Объект не найден');
        }
        return $model;
    }
}
