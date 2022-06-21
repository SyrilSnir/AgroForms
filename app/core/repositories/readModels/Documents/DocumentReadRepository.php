<?php

namespace app\core\repositories\readModels\Documents;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Document\Documents;

/**
 * Description of DocumentReadRepository
 *
 * @author kotov
 */
class DocumentReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Documents::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
