<?php

namespace app\core\repositories\readModels\Contracts;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Contract\Contracts;

/**
 * Description of ContractRepository
 *
 * @author kotov
 */
class ContractReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Contracts::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
