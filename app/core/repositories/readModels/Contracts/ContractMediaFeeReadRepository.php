<?php

namespace app\core\repositories\readModels\Contracts;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Contract\ContractMediaFees;

/**
 * Description of ContractMediaFeesReadRepository
 *
 * @author kotov
 */
class ContractMediaFeeReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return ContractMediaFees::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
