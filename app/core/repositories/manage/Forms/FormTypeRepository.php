<?php

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Forms\FormType;
use yii\db\ActiveRecord;

/**
 * Description of FormTypeRepository
 *
 * @author kotov
 */
class FormTypeRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = FormType::findOne($id)) {
            throw new NotFoundException('Тип не найден');
        }
        return $model;
    }
}
