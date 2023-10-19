<?php

namespace app\core\repositories\readModels\Exhibition;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Exhibition\Catalog;

/**
 * Description of CatalogReadRepository
 *
 * @author kotov
 */
class CatalogReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Catalog::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
