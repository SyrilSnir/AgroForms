<?php

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Forms\Stand;
use yii\db\ActiveRecord;

/**
 * Description of StandRepository
 *
 * @author kotov
 */
class StandRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$post = Stand::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $post;
    }
}
