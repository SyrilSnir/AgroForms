<?php

namespace app\core\repositories\manage\Document;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Document\Documents;
use yii\db\ActiveRecord;

/**
 * Description of DocumentRepository
 *
 * @author kotov
 */
class DocumentRepository implements RepositoryInterface
{
    use DataManipulationTrait;    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Documents::findOne($id)) {
            throw new NotFoundException('Документ не найден');
        }
        return $model;
    }
}
