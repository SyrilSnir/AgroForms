<?php

namespace app\core\repositories\manage\Companies;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Companies\LegalAddress;
use yii\db\ActiveRecord;

/**
 * Description of LegalAddressRepository
 *
 * @author kotov
 */
class LegalAddressRepository implements RepositoryInterface
{
    use DataManipulationTrait;
        
    public function get(int $id): ActiveRecord
    {
        if (!$model = LegalAddress::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $model;
    }
}
