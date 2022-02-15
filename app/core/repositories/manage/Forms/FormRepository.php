<?php

namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Forms\Form;
use yii\db\ActiveRecord;

/**
 * Description of FormRepository
 *
 * @author kotov
 */
class FormRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Form::findOne($id)) {
            throw new NotFoundException('Форма не найдена');
        }
        return $model;
    }
    
    /**
     * 
     * @param ActiveRecord $model
     * @throws RuntimeException
     */
    public function remove(ActiveRecord $model) 
    {
        /** @var Form $model */
        $model->deleted = true;
        if (!$model->save()) {
            throw new RuntimeException('Ошибка удаления');
        }
    }    
}
