<?php

namespace app\core\repositories\manage\Requests;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Requests\Request;
use yii\db\ActiveRecord;

/**
 * Description of RequestRepository
 *
 * @author kotov
 */
class RequestRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Request::findOne($id)) {
            throw new NotFoundException('Заявка не найдена');
        }
        return $model;
    }
}
