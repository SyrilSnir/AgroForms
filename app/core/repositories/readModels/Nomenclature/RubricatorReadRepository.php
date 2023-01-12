<?php

namespace app\core\repositories\readModels\Nomenclature;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Nomenclature\Rubricator;

/**
 * Description of RubricatorReadRepository
 *
 * @author kotov
 */
class RubricatorReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Rubricator::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
