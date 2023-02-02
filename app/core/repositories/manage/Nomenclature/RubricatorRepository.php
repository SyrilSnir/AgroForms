<?php

namespace app\core\repositories\manage\Nomenclature;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use yii\db\ActiveRecord;

/**
 * Description of RubricatorRepository
 *
 * @author kotov
 */
class RubricatorRepository implements RepositoryInterface
{
    use DataManipulationTrait;
        
    public function get(int $id): ActiveRecord
    {
        if (!$model = Rubricator::findOne($id)) {
            throw new NotFoundException('Раздел не найден');
        }
        return $model;
    }
}
