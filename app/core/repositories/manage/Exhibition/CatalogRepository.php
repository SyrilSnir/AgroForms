<?php

namespace app\core\repositories\manage\Exhibition;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Exhibition\Catalog;
use yii\db\ActiveRecord;

/**
 * Description of CatalogRepository
 *
 * @author kotov
 */
class CatalogRepository implements RepositoryInterface
{
    use DataManipulationTrait;
       
    public function get(int $id): ActiveRecord
    {
        if (!$model = Catalog::findOne($id)) {
            throw new NotFoundException('Элемент не найден');
        }
        return $model;
    }
}
