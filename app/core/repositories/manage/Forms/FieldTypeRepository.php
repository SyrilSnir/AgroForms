<?php

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\models\ActiveRecord\Forms\FieldType;
use yii\db\ActiveRecord;

/**
 * Description of FieldTypeRepository
 *
 * @author kotov
 */
class FieldTypeRepository
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = FieldType::findOne($id)) {
            throw new NotFoundException('Не найден выбранный тип поля');
        }
        return $model;
    }
}
