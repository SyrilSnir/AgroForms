<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\ElementType;

/**
 * Description of ElementTypeReadRepository
 *
 * @author kotov
 */
class ElementTypeReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return ElementType::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
