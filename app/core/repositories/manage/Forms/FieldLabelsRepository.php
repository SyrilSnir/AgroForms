<?php

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Forms\FieldLabels;
use yii\db\ActiveRecord;

/**
 * Description of FieldLabelsRepository
 *
 * @author kotov
 */
class FieldLabelsRepository implements RepositoryInterface
{
    use DataManipulationTrait;
       
    public function get(int $id): ActiveRecord
    {
        if (!$model = FieldLabels::findOne($id)) {
            throw new NotFoundException('Метка не найдена');
        }
        return $model;
    }
}
