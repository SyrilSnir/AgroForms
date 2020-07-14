<?php

namespace app\core\repositories\manage\Requests;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Requests\RequestStand;
use yii\db\ActiveRecord;

/**
 * Description of RequestStandRepository
 *
 * @author kotov
 */
class RequestStandRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = RequestStand::findOne($id)) {
            throw new NotFoundException('Заявка не найдена');
        }
        return $model;
    }
}
