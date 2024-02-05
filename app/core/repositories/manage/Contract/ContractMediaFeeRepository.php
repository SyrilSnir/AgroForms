<?php

namespace app\core\repositories\manage\Contract;

use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Contract\ContractMediaFees;
use Mpdf\Container\NotFoundException;
use yii\db\ActiveRecord;

/**
 * Description of ContractMediaFeeRepository
 *
 * @author kotov
 */
class ContractMediaFeeRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = ContractMediaFees::findOne($id)) {
            throw new NotFoundException('Элемент не найден');
        }
        return $model;
    }
}
