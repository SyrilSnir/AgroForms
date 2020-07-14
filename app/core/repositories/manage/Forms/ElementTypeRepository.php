<?php

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Forms\ElementType;
use yii\db\ActiveRecord;

/**
 * Description of ElementTypeRepository
 *
 * @author kotov
 */
class ElementTypeRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = ElementType::findOne($id)) {
            throw new NotFoundException('Не найдена выбранная группа');
        }
        return $model;
    }
}
