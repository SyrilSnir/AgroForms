<?php

namespace app\core\repositories\manage\Requests;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\models\ActiveRecord\Requests\RequestDynamicForm;
use yii\db\ActiveRecord;

/**
 * Description of RequestDynamicFormRepository
 *
 * @author kotov
 */
class RequestDynamicFormRepository
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = RequestDynamicForm::findOne($id)) {
            throw new NotFoundException('Заявка не найдена');
        }
        return $model;
    }
}
