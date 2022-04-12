<?php

namespace app\core\repositories\manage\Contract;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Contract\Contracts;
use yii\db\ActiveRecord;

/**
 * Description of ContractRepository
 *
 * @author kotov
 */
class ContractRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Contracts::findOne($id)) {
            throw new NotFoundException('Договор не найден');
        }
        return $model;
    }
}