<?php

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\models\ActiveRecord\Forms\FieldGroup;
use yii\db\ActiveRecord;

/**
 * Description of FieldGroupRepository
 *
 * @author kotov
 */
class FieldGroupRepository
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = FieldGroup::findOne($id)) {
            throw new NotFoundException('Не найдена выбранная группа');
        }
        return $model;
    }
}
