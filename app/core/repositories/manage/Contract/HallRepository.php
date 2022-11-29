<?php

namespace app\core\repositories\manage\Contract;

use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Contract\Hall;
use Mpdf\Container\NotFoundException;
use yii\db\ActiveRecord;

/**
 * Description of HallRepository
 *
 * @author kotov
 */
class HallRepository implements RepositoryInterface
{
    use DataManipulationTrait;
       
    public function get(int $id): ActiveRecord
    {
        if (!$model = Hall::findOne($id)) {
            throw new NotFoundException('Зал не найден');
        }
        return $model;
    }
}
