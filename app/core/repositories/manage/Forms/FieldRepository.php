<?php

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Forms\Field;
use yii\db\ActiveRecord;

/**
 * Description of FieldRepository
 *
 * @author kotov
 */
class FieldRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Field::findOne($id)) {
            throw new NotFoundException('Не найдено выбранное поле');
        }
        return $model;
    }
}
