<?php

namespace app\core\repositories\manage\Exhibition;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Exhibition\Exhibition;
use yii\db\ActiveRecord;

/**
 * Description of ExhibitionRepository
 *
 * @author kotov
 */
class ExhibitionRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Exhibition::findOne($id)) {
            throw new NotFoundException('Выставка не найдена');
        }
        return $model;
    }
}
