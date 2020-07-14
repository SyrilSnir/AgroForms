<?php

namespace app\core\repositories\manage\Companies;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Companies\BankDetail;
use yii\db\ActiveRecord;

/**
 * Description of BankDetailRepository
 *
 * @author kotov
 */
class BankDetailRepository implements RepositoryInterface
{
    use DataManipulationTrait;
        
    public function get(int $id): ActiveRecord
    {
        if (!$model = BankDetail::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $model;
    }
}
